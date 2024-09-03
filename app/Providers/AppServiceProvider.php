<?php

namespace App\Providers;

use App\Models\Bidang;
use App\Policies\BidangPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Password::defaults(function () {
            $rule = Password::min(8);
            $strictRule = Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised();

            return App::isProduction()? $strictRule : $rule;

        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject("Verifikasi Akun SI Salman ITB")
                ->greeting("Selamat Bergabung!")
                ->line('Terima kasih telah mendaftar ke Sistem Informasi Masjid Salman ITB! Untuk menyelesaikan pendaftaran anda, dimohon untuk menggunakan tombol dibawah ini untuk memverifikasi email yang anda gunakan')
                ->action('Verifikasi Email', $url)
                ->line('Jika anda tidak merasa melakukan pendaftaran pada SI Salman ITB, tidak perlu melakukan tindakan lebih lanjut. Akun tidak akan dapat digunakan jika tidak memiliki email yang terverifikasi.');
        });

        
    }
}
