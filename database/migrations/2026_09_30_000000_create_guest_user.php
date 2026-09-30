<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const GUEST_EMAIL = 'guest@crescent.local';

    public function up(): void
    {
        $connection = DB::connection();
        $existingGuest = $connection->table('users')->where('id', 0)->first();

        if ($existingGuest) {
            if ($existingGuest->email !== self::GUEST_EMAIL) {
                throw new RuntimeException('User ID 0 is already assigned to another account.');
            }

            return;
        }

        $driver = $connection->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $connection->statement("SET SESSION sql_mode = CONCAT_WS(',', @@SESSION.sql_mode, 'NO_AUTO_VALUE_ON_ZERO')");
        } elseif ($driver === 'sqlsrv') {
            $connection->statement('SET IDENTITY_INSERT users ON');
        }

        try {
            $connection->table('users')->insert([
                'id' => 0,
                'first_name' => 'Guest',
                'last_name' => 'User',
                'email' => self::GUEST_EMAIL,
                'password' => Hash::make(Str::random(64)),
                'role' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } finally {
            if ($driver === 'sqlsrv') {
                $connection->statement('SET IDENTITY_INSERT users OFF');
            }
        }
    }

    public function down(): void
    {
        DB::table('users')
            ->where('id', 0)
            ->where('email', self::GUEST_EMAIL)
            ->delete();
    }
};