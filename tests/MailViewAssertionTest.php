<?php


namespace YlsIdeas\LaravelAdditions\Tests;

use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;
use NunoMaduro\LaravelMojito\ViewAssertion;
use Orchestra\Testbench\TestCase;
use YlsIdeas\LaravelAdditions\Support\MailViewAssertion;

class MailViewAssertionTest extends TestCase
{
    public function testItProcessesMailableAssertions()
    {
        $callable = MailViewAssertion::make(function (ViewAssertion $assertion) {
            $assertion->contains('Hello');

            return true;
        });

        $view = <<<'EOT'
{{ $message }}
EOT;

        File::put(resource_path('views/something.blade.php'), $view);

        $mailable = new class('something', ['message' => 'Hello']) extends Mailable {
            public function __construct($view, $viewData)
            {
                $this->view = $view;
                $this->viewData = $viewData;
            }
        };

        return $callable($mailable);
    }

    public function testItProcessesNotificationAssertions()
    {


        $notification = new class extends Notification {
            public function toMail()
            {
                return (new MailMessage())
                    ->line('Hello');
            }
        };

        $notifiable = new class {
            use Notifiable;
        };

        $callable = MailViewAssertion::make(function (
            ViewAssertion $assertion,
            $channel,
            $notifiableInstance,
            $locale
        ) use ($notifiable) {
            $assertion->contains('Hello');
            $this->assertSame($notifiable, $notifiableInstance);
            $this->assertSame('mail', $channel);
            $this->assertSame('en', $locale);

            return true;
        });

        return $callable($notification, 'mail', $notifiable, 'en');
    }
}
