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
                
                header('location:'.FRONT_ROOT.'Home/Index');
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