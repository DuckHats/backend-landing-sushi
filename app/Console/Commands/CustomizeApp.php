<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CustomizeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:customize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively customize application branding and colors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Welcome to the App Customizer!');
        $this->line('This command will help you configure the branding and colors of your application.');
        $this->line('Values will be saved to your .env file.');
        $this->newLine();

        // Admin user info
        $adminName = $this->ask('Admin Name', config('customization.admin.name'));
        $adminEmail = $this->ask('Admin Email', config('customization.admin.email'));
        $adminPassword = $this->secret('Admin Password', config('customization.admin.password'));

        // Brand Info
        $name = $this->ask('Brand Name', config('customization.name'));
        $email = $this->ask('Contact Email', config('customization.email'));
        $phone = $this->ask('Phone Number', config('customization.phone'));
        $address = $this->ask('Address', config('customization.address'));

        $this->newLine();
        $this->info('Landing Page Texts');
        $welcomeTitle = $this->ask('Welcome Title', config('customization.welcome.title'));
        $welcomeSubtitle = $this->ask('Welcome Subtitle', config('customization.welcome.subtitle'));

        $this->newLine();
        $this->info('Brand Colors (Hex format)');
        $primary = $this->ask('Primary Color (e.g. #722022)', config('customization.colors.primary'));
        $secondary = $this->ask('Secondary Color (e.g. #8A9556)', config('customization.colors.secondary'));
        $tertiary = $this->ask('Tertiary (Gray) Color', config('customization.colors.tertiary'));
        $black = $this->ask('Black Color', config('customization.colors.black'));
        $white = $this->ask('White Color', config('customization.colors.white'));
        $beige = $this->ask('Beige Color', config('customization.colors.beige'));

        $data = [
            'APP_BRAND_NAME' => $name,
            'APP_CONTACT_EMAIL' => $email,
            'APP_BRAND_PHONE' => $phone,
            'APP_BRAND_ADDRESS' => $address,
            'APP_WELCOME_TITLE' => $welcomeTitle,
            'APP_WELCOME_SUBTITLE' => $welcomeSubtitle,
            'APP_COLOR_PRIMARY' => $primary,
            'APP_COLOR_SECONDARY' => $secondary,
            'APP_COLOR_TERTIARY' => $tertiary,
            'APP_COLOR_BLACK' => $black,
            'APP_COLOR_WHITE' => $white,
            'APP_COLOR_BEIGE' => $beige,
            'APP_ADMIN_NAME' => $adminName,
            'APP_ADMIN_EMAIL' => $adminEmail,
            'APP_ADMIN_PASSWORD' => $adminPassword,

        ];

        if ($this->confirm('Do you want to save these changes to .env?', true)) {
            $this->updateEnv($data);
            $this->info('Changes saved successfully!');
            $this->call('config:clear');
        } else {
            $this->warn('Changes discarded.');
        }
    }

    /**
     * Update the .env file with the provided data.
     *
     * @param array $data
     * @return void
     */
    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            File::copy(base_path('.env.example'), $envPath);
        }

        $content = File::get($envPath);

        foreach ($data as $key => $value) {
            if (preg_match("/^{$key}=/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $content);
            } else {
                $content .= "\n{$key}=\"{$value}\"";
            }
        }

        File::put($envPath, $content);
    }
}
