<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles exist
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Operator']);
    }

    public function test_unauthenticated_user_cannot_access_activity_logs(): void
    {
        $response = $this->get(route('admin.activity-logs.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_operator_role_cannot_access_activity_logs(): void
    {
        $operator = User::firstOrCreate(
            ['email' => 'operator_test@example.com'],
            ['name' => 'Operator Test', 'password' => Hash::make('password')]
        );
        $operator->syncRoles(['Operator']);

        $response = $this->actingAs($operator)->get(route('admin.activity-logs.index'));
        $response->assertStatus(403);
    }

    public function test_admin_role_can_access_activity_logs_index(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => Hash::make('password')]
        );
        $admin->syncRoles(['Admin']);

        $response = $this->actingAs($admin)->get(route('admin.activity-logs.index'));
        $response->assertStatus(200);
        $response->assertSee('Log Aktivitas Pengguna');
    }

    public function test_activity_is_logged_when_user_logs_in(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'login_test@example.com'],
            ['name' => 'Login Tester', 'password' => Hash::make('password123')]
        );

        $this->post('/login', [
            'email' => 'login_test@example.com',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'login',
            'module' => 'Autentikasi',
        ]);
    }

    public function test_model_operations_generate_activity_logs(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_crud@example.com'],
            ['name' => 'Admin CRUD', 'password' => Hash::make('password')]
        );
        $admin->syncRoles(['Admin']);

        $this->actingAs($admin);

        // 1. Create
        $jenis = JenisDokumen::create([
            'tipe_dokumen' => 'Produk Hukum',
            'nama' => 'Uji Log Peraturan',
            'kode' => 'ULP',
            'deskripsi' => 'Uji coba log aktivitas',
            'urutan' => 99,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'create',
            'subject_id' => $jenis->id,
            'user_id' => $admin->id,
        ]);

        // 2. Update
        $jenis->update([
            'nama' => 'Uji Log Peraturan Diperbarui',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'update',
            'subject_id' => $jenis->id,
            'user_id' => $admin->id,
        ]);

        // 3. Delete
        $jenisId = $jenis->id;
        $jenis->delete();

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'delete',
            'subject_id' => $jenisId,
            'user_id' => $admin->id,
        ]);
    }

    public function test_admin_can_view_log_detail_via_json(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => Hash::make('password')]
        );
        $admin->syncRoles(['Admin']);

        $log = ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'user_email' => $admin->email,
            'user_role' => 'Admin',
            'action' => 'create',
            'module' => 'Dokumen Hukum',
            'description' => 'Test detail view',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.activity-logs.show', $log->id));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $log->id,
                'description' => 'Test detail view',
            ]
        ]);
    }

    public function test_admin_can_delete_activity_log(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => Hash::make('password')]
        );
        $admin->syncRoles(['Admin']);

        $log = ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => 'delete',
            'module' => 'Berita',
            'description' => 'Test delete log',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.activity-logs.destroy', $log->id));
        $response->assertRedirect(route('admin.activity-logs.index'));
        $this->assertDatabaseMissing('activity_logs', ['id' => $log->id]);
    }

    public function test_admin_can_clear_logs(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => Hash::make('password')]
        );
        $admin->syncRoles(['Admin']);

        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => 'delete',
            'module' => 'Berita',
            'description' => 'Test log to clear',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.activity-logs.clear'), ['period' => 'all']);
        $response->assertRedirect(route('admin.activity-logs.index'));
        $this->assertEquals(0, ActivityLog::count());
    }
}
