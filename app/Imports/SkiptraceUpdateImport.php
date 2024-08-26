<?php
namespace App\Imports;

use App\Models\ClientValidation;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SkiptraceUpdateImport implements ToCollection, WithHeadingRow
{
    use Importable;
    protected $fileName;
    protected $userId;

    /**
     * Create a new import instance.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        // $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $no_ktp = $row['no_ktp'] ?? null;
            $phone_number = trim($row['no_hp'] ?? '');
            $activation_date = $row['age'] ? Carbon::instance(Date::excelToDateTimeObject($row['age'])) : null;

            $status_no = null;
            if (in_array($phone_number, ['NIK_NOT_VALID', '#N/A'], true)) {
                $status_no = $phone_number;
                $phone_number = null;
            }

            $ktp = Contact::where('no_ktp', $no_ktp)->first();
            $pn = Contact::where('phone_number', $phone_number)->first();
            if ($ktp&&empty($ktp->phone_number)) {
                $ktp->update([
                    'phone_number' => $phone_number,
                    'status_no' => $status_no,
                    'activation_date' => $activation_date,
                    'file_name' => $this->fileName,
                ]);
            } elseif ($pn && empty($pn->no_ktp)) {
                $pn->update([
                    'no_ktp' => $no_ktp,
                    'status_no' => $status_no,
                    'activation_date' => $activation_date,
                    'file_name' => $this->fileName,
                ]);
            } elseif (empty($pn->phone_number)) {
                $contact=Contact::create([
                    'no_ktp' => $no_ktp,
                    'phone_number' => $phone_number,
                    'status_no' => $status_no,
                    'activation_date' => $activation_date,
                    'type' => 'skip_trace',
                    'file_name' => $this->fileName,
                ]);
                // ClientValidation::updateOrCreate([
                //     'contact_id' => $contact->id,
                //     'user_id' => $this->userId,
                // ,[]]);
            }
            //ADD KTP KE USER REQUEST
            $getKtp = Contact::where('no_ktp', $no_ktp)->get();
            if($getKtp){
                foreach($getKtp as $key => $gk){
                    if($key==0){
                        $clientRequest = ClientValidation::where('contact_id', $gk->id)->get();
                    }
                    if($clientRequest){
                        foreach( $clientRequest as $cr){
                            ClientValidation::updateOrCreate([
                                'contact_id' => $gk->id,
                                'user_id' => $cr->user_id,
                                'type' => 'skip_trace'
                            ],['updated_at' => date('Y-m-d H:i:s')]);
                        }
                    }
                }
            }

        }
    }
}
