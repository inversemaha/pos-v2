<?php

namespace App\Http\Controllers;

use App\Models\SmsTrack;
use Illuminate\Http\Request;
use SoapClient;

class AdminController extends Controller
{ public function home(Request $request)
{
    return view('pages.home.index');
}

    public function sendSms(Request $request)
    {
        if ($request->isMethod('post')) {
            $message = $request['message'];
            if ($request->hasFile('file')) {

                $path = $request->file('file')->getRealPath();

                /* try {
                     $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                     $spreadsheet = $reader->load($path);
                     return print_r($spreadsheet);
                 } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                 }*/

                try {
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

                    $worksheet = $spreadsheet->getActiveSheet();

                    $maxCell = $worksheet->getHighestRowAndColumn();
                    //return $maxCell['column'] .' : '. $maxCell['row'];

                    /*  $highestRow = $worksheet->getHighestRowWhereCellExistsAndIsNonBlank();
                      $highestRow = $worksheet->getHighestDataRow();
                      $highestCol = $worksheet->getHighestDataColumn();

                      return $highestRow . ' : '. $highestCol;*/

                    $worksheet->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
                    //return $data = $worksheet->rangeToArray('A1:' . $highestColumn . $highestRow, null, true, false, false);

                    $rows = [];
                    $counter = 1;
                    foreach ($worksheet->getRowIterator() AS $row) {

                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                        $cells = [];
                        foreach ($cellIterator as $cell) {
                            $cells[] = $cell->getValue();
                        }
                        $rows[] = $cells;
                        if ($cells[1] == null) {
                            break;
                        } else {
                            $value = $this->sentMessage($cells[0], '0' . $cells[1], $message);
                            if ($value == 1) {
                                $this->saveIntoDb($cells[0], '0' . $cells[1], $message);
                            }
                        }
                    }

                } catch (\Exception $e) {
                }

                return back()->with('success', $counter);

            }
        } else {
            return view('pages.sms.index');
        }

    }

    public function statistics(Request $request)
    {
        $result = SmsTrack::orderBy('sms_id', 'DESC')->get();
        return view('pages.sms.statistics')->with('result', $result);
    }

    private function sentMessage($name, $phone, $message)
    {
        $message = "Congratulations " . $name . "! As a GCP Badge Holder, You are selected for Google Cloud Next'18 Bangladesh. Date: 12 October 2018 (Friday) Time: 2.30 PM. Venue: University of Asia Pacific Organized By: GDG Bangla";
        try {
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'userName' => "01717849968",
                'userPassword' => "3f718e",
                'mobileNumber' => $phone,
                'smsText' => $message,
                'type' => "TEXT",
                'maskName' => '',
                'campaignName' => '',
            );
            $value = $soapClient->__call("OneToOne", array($paramArray));
            echo $value->OneToOneResult;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return 1;

    }

    private function saveIntoDb($name, $phone, $message)
    {
        //$user_id = Session::get('id');
        $message = "Congratulations ".$name."! As a GCP Badge Holder, You are selected for Google Cloud Next'18 Bangladesh. Date: 12 October 2018 (Friday) Time: 2.30 PM. Venue: University of Asia Pacific Organized By: GDG Bangla";
        $user_id = 1;
        try {
            SmsTrack::create(['user_id' => $user_id, 'name' => $name, 'phone' => $phone, 'message' => $message]);
        } catch (\Exception $exception) {

        }


    }
}
