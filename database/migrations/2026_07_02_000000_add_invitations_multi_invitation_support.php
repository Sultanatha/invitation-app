<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('template_key')->default('default');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $defaultInvitationId = 1;

        if (! DB::connection()->pretending()) {
            $defaultInvitationId = DB::table('invitations')->insertGetId([
                'title' => 'Undangan Default',
                'slug' => 'default',
                'template_key' => 'default',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->invitationTables() as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->foreignId('invitation_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->cascadeOnDelete();
            });

            DB::table($tableName)->update(['invitation_id' => $defaultInvitationId]);
        }

        Schema::table('settings', function (Blueprint $table): void {
            $table->dropUnique('settings_key_unique');
            $table->unique(['invitation_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table): void {
            $table->dropUnique(['invitation_id', 'key']);
            $table->unique('key');
        });

        foreach (array_reverse($this->invitationTables()) as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->dropConstrainedForeignId('invitation_id');
            });
        }

        Schema::dropIfExists('invitations');
    }

    private function invitationTables(): array
    {
        return [
            'settings',
            'hero_sections',
            'couples',
            'event_schedules',
            'love_stories',
            'galleries',
            'gifts',
            'rsvps',
        ];
    }
};
