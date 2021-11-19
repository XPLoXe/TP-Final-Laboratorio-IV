<?php
    namespace Controllers;

    use Utils\Utils as Utils;

    class HomeController
    {
        public function Index(?array $text): void
        {
            if (Utils::isUserLoggedIn())
            {
                $prices = $this->GetPricesFromBinance();

                foreach ($prices as $k => $v)
                {
                    if ($v['symbol'] == 'BTCUSDT')
                    {
                        $btc = (double)$v['price'];
                    }
                    
                    if ($v['symbol'] == 'ETHUSDT')
                    {
                        $eth = (double)$v['price'];
                    }
                    
                    if ($v['symbol'] == 'LTCUSDT')
                    {
                        $ltc = (double)$v['price'];
                    }
                }
                
                if(is_null($text))
                {
                    $message = " ";
                }
                else
                {
                    $message = $text['message'];
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
        }
    }