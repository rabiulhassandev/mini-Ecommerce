<?php

namespace App\Sms;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SMS
{
    private $type = 'text';

    private $contacts;

    private $msg;

    private static function API_KEY()
    {
        return config('sms.api_key');
    }

    private static function SENDER_ID()
    {
        return config('sms.sender_id');
    }

    private static function CLIENT()
    {
        return new Client(['verify' => config('sms.verify'), 'base_uri' => config('sms.base_uri')]);
    }

    public function __construct($contacts, $msg = null, $type = 'text')
    {
        $this->contacts = $contacts;
        $this->msg = $msg;
        $this->type = $type;
        if (self::API_KEY() == '' || self::SENDER_ID() == '') {
            throw new \Exception('Api Key Or Approved Sender ID dose not match !', 1010);
        }
    }

    /***
     *
     *
     * one to one relationship static method
     *
     *
     * calling syntax
     *
     -------------------------------------------------
     $contacts"= ['88017xxxxxxxx',+'88018xxxxxxxx'];
     $msg = "this is a demo message";
     -------------------------------------------------
     *
     *
     */
    public static function OneToOne($contacts, $msg, $type = 'text'): self
    {
        if (is_array($contacts)) {
            $numbers = [];
            foreach ($contacts as $key => $value) {
                if ($key == 0) {
                    if (strlen($value) == 11) {
                        array_push($numbers, $value);
                    } elseif (strlen($value) == 14) {
                        array_push($numbers, substr($value, 3, 14));
                    } else {
                        throw new \Exception('Number Not Valid', 1012);
                    }

                    continue;
                }
                if (strlen($value) == 11) {
                    array_push($numbers, '+88'.$value);
                } elseif (strlen($value) == 14) {
                    array_push($numbers, '+88'.substr($value, 3, 14));
                }
            }
            $contacts = implode('', $numbers);
        } else {
            if (strlen($contacts) == 11) {
                //
            } elseif (strlen($contacts) == 14) {
                $contacts = substr($contacts, 3, 14);
            } else {
                throw new \Exception('Number Not Valid', 1012);
            }
        }

        return new static($contacts, $msg, $type);
    }

    /***
     *
     *
     * many to many relationship static method
     *
     *
     * calling syntax
     *
     ------------------------------------------------
        $messages = [
                        [
                            'to' => '01712345678',
                            'message' => 'test1'

                        ],
                        [
                            'to' => '01512345678',
                            'message' => 'test2'

                        ],
                    ];
    --------------------------------------------------
     *
     *
     */
    public static function ManyToMany($contacts): self
    {
        if (is_array($contacts)) {
            foreach ($contacts as $key => $value) {
                if ((! isset($value['message'])) || (! isset($value['to']))) {
                    throw new \Exception('Format Not  Valid', 1014);
                }
            }
        } else {
            throw new \Exception('Format Not  Valid', 1014);
        }

        return new static($contacts);
    }

    /**
     * TO Check Account Balance
     */
    public static function CheckBalance()
    {
        $response = self::CLIENT()->request('GET', 'miscapi/'.self::API_KEY().'/getBalance');

        return $response->getBody();
    }

    /**
     *Error Code	Meaning
     *1002	Sender Id/Masking Not Found
     *1003	API Not Found
     *1004	SPAM Detected
     *1005	Internal Error
     *1006	Internal Error
     *1007	Balance Insufficient
     *1008	Message is empty
     *1009	Message Type Not Set (text/unicode)
     *1010	Invalid User & Password
     *1011	Invalid User Id
     *1012	Invalid Number
     *1013	API limit error
     *1014	No matching template
     */

    /**
     * If sms sent true return else throws Exception
     *
     * @param $numbers
     * @param $message
     * @return bool
     *
     * @throws \Exception
     */
    public function send()
    {
        if ($this->msg) {
            $data = [
                'api_key' => self::API_KEY(),
                'type' => $this->type,
                'contacts' => $this->contacts,
                'senderid' => self::SENDER_ID(),
                'msg' => $this->msg,
            ];
            $response = self::CLIENT()->post('smsapi', [
                'form_params' => $data,
            ]);
        } else {
            $data = [
                'api_key' => self::API_KEY(),
                'senderid' => self::SENDER_ID(),
                'messages' => json_encode($this->contacts),
                // 'messages' => json_encode($this->contacts),
            ];
            $response = self::CLIENT()->post('smsapimany', [
                'form_params' => $data,
            ]);
        }
        /**
         *Error Code	Meaning
         *1002	Sender Id/Masking Not Found
         *1003	API Not Found
         *1004	SPAM Detected
         *1005	Internal Error
         *1006	Internal Error
         *1007	Balance Insufficient
         *1008	Message is empty
         *1009	Message Type Not Set (text/unicode)
         *1010	Invalid User & Password
         *1011	Invalid User Id
         *1012	Invalid Number
         *1013	API limit error
         *1014	No matching template
         */
        switch ((string) $response->getBody()) {
            case 1002:
                self::logError($response);
                throw new \Exception('Sender Id/Masking Not Found', 1002);
                break;
            case 1003:
                self::logError($response);
                throw new \Exception('API Not Found', 1003);
                break;
            case 1004:
                self::logError($response);
                throw new \Exception('SPAM Detected', 1004);
                break;
            case 1005:
                self::logError($response);
                throw new \Exception('Internal Error', 1005);
                break;
            case 1006:
                self::logError($response);
                throw new \Exception('Internal Error', 1006);
                break;
            case 1007:
                self::logError($response);
                throw new \Exception('Balance Insufficient', 1007);
                break;
            case 1008:
                self::logError($response);
                throw new \Exception('Message is empty', 1008);
                break;
            case 1009:
                self::logError($response);
                throw new \Exception('Message Type Not Set (text/unicode)', 1009);
                break;
            case 1010:
                self::logError($response);
                throw new \Exception('Invalid User & Password', 1010);
                break;
            case 1011:
                self::logError($response);
                throw new \Exception('Invalid User Id', 1011);
                break;
            case 1012:
                self::logError($response);
                throw new \Exception('Invalid Number', 1012);
                break;
            case 1013:
                self::logError($response);
                throw new \Exception('API limit error', 1013);
                break;

            case 1014:
                self::logError($response);
                throw new \Exception('No matching template)', 1014);
                break;
            default:
                self::logError($response);

                return true;
                break;
        }
        self::logError($response);
        throw new \Exception('Unknown', -1);
    }

    /**
     * Log error in topup-log file
     *
     * @param $response
     */
    private static function logError($error)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/sms-log.log'),
        ])->error((array) $error ?? []);
    }
}
