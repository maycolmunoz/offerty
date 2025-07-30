<?php

namespace Estivenm0\Moonlaunch\Console\Commands;

use Illuminate\Console\Command;

class LaunchInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launch:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure moonshine launch package';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->runStep('🔧 Generating application key...', 'key:generate');
        $this->runStep('📦 Running migrations...', 'migrate');
        $this->runStep('🔐 Generating permissions...', 'launch:permissions');
        $this->runStep('🌱 Running database seeders...', 'db:seed');
        $this->runStep('👤 Creating Super Admin user...', 'moonshine-rbac:user');
        $this->runStep('🔗 Linking storage...', 'storage:link');
        $this->info('✅ Moonlaunch installed successfully.');
    }

    protected function runStep(string $message, string $command): void
    {
        $this->info($message);
        $this->call($command);
    }
}
