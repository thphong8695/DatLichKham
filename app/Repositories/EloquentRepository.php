<?php

namespace App\Repositories;
use DB;
use Auth;
use App\Models\BenhVienPK;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;

class EloquentRepository
{
    private $userName;
    private $password;
    private $parameters = array();

    const SERVICE_URI = 'http://ams.tinnhanthuonghieu.vn:8009/bulkapi?wsdl';
    //const SERVICE_URI = 'http://125.235.4.202:8998/bulkapi?wsdl';
    
        
    const TEST_USER = 'tongdai1068';
    const TEST_PASS = '147a@258';
    const TEST_CPCODE = 'TONGDAI1068';
    const TEST_ALIAS = 'VTBooking';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendBulkSms($message, $toNumbers) {
        $client = new SoapClient(self::SERVICE_URI);
        $params = array(    
            "User" => self::TEST_USER,
            "Password" => self::TEST_PASS,
            "CPCode" => self::TEST_CPCODE,
            "RequestID" => "1",
            "UserID" => $toNumbers,
            "ReceiverID" => $toNumbers,
            "ServiceID" => self::TEST_ALIAS,
            "CommandCode" => "bulksms",
            "Content" => $message,
            "ContentType" => "0"     
          );
        $response = $client->__soapCall("wsCpMt", array($params));
        return $response;
    }
    public function getListBenhVienSlug()
    {
        $benhvien = BenhVienPK::where('status',1)->pluck('name','slug')->all();
        return $benhvien;
    }
    public function getListBenhVienId()
    {
        $benhvien = BenhVienPK::where('status',1)->pluck('name','id')->all();
        return $benhvien;
    }
}