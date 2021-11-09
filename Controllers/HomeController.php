<?php
    namespace Controllers;

    use Utils\Utils as Utils;

    class HomeController
    {
        public function Index($message = ""): void
        {
            if (Utils::isUserLoggedIn())
            {
                $message = "";
                $prices = $this->GetPricesFromBinance();
                $btc = '';
                $eth = '';
                $ltc = '';

                foreach ($prices as $k => $v)
                {
                    if ($v['symbol'] == 'BTCUSDT')
                    {
                        $btc = $v['price'];
                    }
                    
                    if ($v['symbol'] == 'ETHUSDT')
                    {
                        $eth = $v['price'];
                    }
                    
                    if ($v['symbol'] == 'LTCUSDT')
                    {
                        $ltc = $v['price'];
                    }
                }
                
                require_once(VIEWS_PATH."home.php");
            }
            else
            {
                $message = "";
                require_once(VIEWS_PATH."login.php");
            }
        }

        private function GetPricesFromBinance()
        {
            $data = file_get_contents(BINANCE_URL);
            $json = json_decode($data, true);

            return $json;

            /* $btc = '';
            $eth = '';
            $ltc = '';

            foreach ($json as $k => $v)
            {
                if ($v['symbol'] == 'BTCUSDT')
                {
                    $btc = $v['price'];
                }
                
                if ($v['symbol'] == 'ETHUSDT')
                {
                    $eth = $v['price'];
                }
                
                if ($v['symbol'] == 'LTCUSDT')
                {
                    $ltc = $v['price'];
                }
                

            } */

        }
    }