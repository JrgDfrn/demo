<?php

use Filament\CustomDashboardsPlugin\Attributes\CustomDashboardsPluginMigration;
use Filament\CustomDashboardsPlugin\Enums\MigrationName;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new #[CustomDashboardsPluginMigration(MigrationName::DashboardUserTable)] class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filament_cd_dashboard_user', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dashboard_id')->constrained('filament_cd_dashboards')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filament_cd_dashboard_user');
    }
};
