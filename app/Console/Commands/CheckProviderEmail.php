<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckProviderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:email {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check provider email status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request['to'] = 'archeeshop1@gmail.com';
        $request['title'] = 'testing email';
        $request['text'] = 'testing email';

        if($this->argument('provider')=='smtp2go'){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
            curl_setopt($curl, CURLOPT_URL,
                "https://api.smtp2go.com/v3/email/send"
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
                "api_key" => "api-DC84566695C24F1E81D5B0EAAA0B1F50",
                "sender" => "noreply@hireach.archeeshop.com",
                "to" => array(
                    0 => $request['to']
                ),
                "subject" => $request['title'],
                "html_body" => "<div>".$request['text']."</div>",
                "text_body" => $request['text']
            )));
            $result = curl_exec($curl);
            $rs = json_decode($result, true);
            if($rs['data']['succeeded']){
                $this->line("EMAIL is OK");
            }else{
                $this->line("EMAIL is ERROR");
            }
        }
    }
}
