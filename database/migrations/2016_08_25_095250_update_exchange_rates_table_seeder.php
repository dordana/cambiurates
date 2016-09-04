<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\ExchangeRate;

class UpdateExchangeRatesTableSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exchange_rates = array(
            array('symbol' => 'AED','exchange_rate' => '4.778534','title' => 'UAE DIRHAM'),
            array('symbol' => 'AUD','exchange_rate' => '1.685161','title' => 'AUSTRALIA DOLLAR'),
            array('symbol' => 'BBD','exchange_rate' => '2.601979','title' => 'BARBADOS DOLLAR'),
            array('symbol' => 'BGN','exchange_rate' => '2.277323','title' => 'BULGARIA LEV'),
            array('symbol' => 'BHD','exchange_rate' => '0.490499','title' => 'BAHRAIN DINARS'),
            array('symbol' => 'BMD','exchange_rate' => '1.300989','title' => 'BERMUDA DOLLAR'),
            array('symbol' => 'BRL','exchange_rate' => '4.080033','title' => 'BRAZIL REALS'),
            array('symbol' => 'BSD','exchange_rate' => '1.300989','title' => 'BAHARMAIN DOLLAR '),
            array('symbol' => 'CAD','exchange_rate' => '1.697123','title' => 'CANADA DOLLAR'),
            array('symbol' => 'CHF','exchange_rate' => '1.269813','title' => 'SWITZERLAND FRANC'),
            array('symbol' => 'CLP','exchange_rate' => '845.408428','title' => 'CHILEAN PESO'),
            array('symbol' => 'CNY','exchange_rate' => '8.636637','title' => 'CHINA YUAN RENMINBI'),
            array('symbol' => 'CRC','exchange_rate' => '707.282908','title' => 'COSTA RICAN COLON'),
            array('symbol' => 'CZK','exchange_rate' => '31.487050','title' => 'CZECH KORUNA'),
            array('symbol' => 'DKK','exchange_rate' => '8.663384','title' => 'DENMARK KRONER'),
            array('symbol' => 'DOP','exchange_rate' => '59.852016','title' => 'DOMINICAN REPUBLIC PESOS'),
            array('symbol' => 'EGP','exchange_rate' => '11.526766','title' => 'EGYPTIAN POUND'),
            array('symbol' => 'EUR','exchange_rate' => '1.164772','title' => 'Euro'),
            array('symbol' => 'FJD','exchange_rate' => '2.674701','title' => 'FIJIAN DOLLAR'),
            array('symbol' => 'HKD','exchange_rate' => '10.091574','title' => 'HONG KONG DOLLAR'),
            array('symbol' => 'HRK','exchange_rate' => '8.719730','title' => 'CROATIA KUNA'),
            array('symbol' => 'HUF','exchange_rate' => '361.715059','title' => 'HUNGARIAN FORINT'),
            array('symbol' => 'IDR','exchange_rate' => '16921.058296','title' => 'INDONESIA RUPIAHS'),
            array('symbol' => 'ILS','exchange_rate' => '4.968810','title' => 'ISRAEL NEW SHEKEL'),
            array('symbol' => 'ISK','exchange_rate' => '154.544289','title' => 'ICELAND KRONUR'),
            array('symbol' => 'JMD','exchange_rate' => '164.096388','title' => 'JAMAICA DOLLAR'),
            array('symbol' => 'JOD','exchange_rate' => '0.920848','title' => 'JORDAN DINAR'),
            array('symbol' => 'JPY','exchange_rate' => '131.825427','title' => 'JAPAN YEN'),
            array('symbol' => 'KES','exchange_rate' => '132.115471','title' => 'KENYA SHILLINGS'),
            array('symbol' => 'KRW','exchange_rate' => '1426.428275','title' => 'SOUTH KOREA WON'),
            array('symbol' => 'KWD','exchange_rate' => '0.392443','title' => 'KUWAITI DINAR'),
            array('symbol' => 'KYD','exchange_rate' => '1.066811','title' => 'CAYMAN ISLANDS DOLLAR'),
            array('symbol' => 'MUR','exchange_rate' => '45.859875','title' => 'MAURITIUS RUPEES'),
            array('symbol' => 'MXN','exchange_rate' => '23.883484','title' => 'MEXICAN PESO'),
            array('symbol' => 'MYR','exchange_rate' => '5.197890','title' => 'MALAYSIA RINGGIT'),
            array('symbol' => 'NOK','exchange_rate' => '10.753385','title' => 'NORWAY KRONER'),
            array('symbol' => 'NZD','exchange_rate' => '1.803512','title' => 'NEW ZEALAND DOLLAR'),
            array('symbol' => 'OMR','exchange_rate' => '0.500622','title' => 'OMAN RIAL'),
            array('symbol' => 'PEN','exchange_rate' => '4.303673','title' => 'PERUVIAN NUEVO SOL'),
            array('symbol' => 'PHP','exchange_rate' => '60.645620','title' => 'PHILIPPINES PESOS'),
            array('symbol' => 'PLN','exchange_rate' => '4.971313','title' => 'POLAND ZLOTY'),
            array('symbol' => 'QAR','exchange_rate' => '4.737553','title' => 'QATAR RIYAL'),
            array('symbol' => 'RON','exchange_rate' => '5.192988','title' => 'ROMANIAN LEU'),
            array('symbol' => 'RUB','exchange_rate' => '84.172866','title' => 'RUSSIA RUBLES'),
            array('symbol' => 'SAR','exchange_rate' => '4.879426','title' => 'SAUDI ARABIA RIYAL'),
            array('symbol' => 'SEK','exchange_rate' => '11.010933','title' => 'SWEDEN KRONER'),
            array('symbol' => 'SGD','exchange_rate' => '1.744099','title' => 'SINGAPORE DOLLAR'),
            array('symbol' => 'THB','exchange_rate' => '45.209588','title' => 'THAILAND BAHT'),
            array('symbol' => 'TRY','exchange_rate' => '3.848897','title' => 'TURKEY LIRA'),
            array('symbol' => 'TTD','exchange_rate' => '8.677599','title' => 'T & T DOLLAR'),
            array('symbol' => 'TWD','exchange_rate' => '40.423872','title' => 'TAIWAN NEW DOLLARS'),
            array('symbol' => 'USD','exchange_rate' => '1.300989','title' => 'UNITED STATES DOLLAR'),
            array('symbol' => 'XCD','exchange_rate' => '3.512671','title' => 'EAST CARIBBEAN DOLLAR'),
            array('symbol' => 'ZAR','exchange_rate' => '17.334123','title' => 'SOUTH AFRICA RAND')
        );
        
        foreach ($exchange_rates as $rate) {
            ExchangeRate::create($rate);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('exchange_rates')->truncate();
    }
}
