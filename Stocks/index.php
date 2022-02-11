<?php

use GuzzleHttp\Psr7\Response;

require_once(__DIR__ . '/vendor/autoload.php');

$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c82gr7aad3ia12592efg');
$client = new Finnhub\Api\DefaultApi(
    new GuzzleHttp\Client(),
    $config
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks</title>
    <style>
    *{
        margin: auto;
    }
    body{
        background-color: rgb(110, 110, 110);
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }
    img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid rgba(110, 110, 110, .3);
    }

    div {
        display: flex;
        padding: 5px;
        
    }

    p {
        padding-left: 5px;
        padding-right: 5px;
        color:green;
        font-weight: bold;
    }

    .Stock-bg {
        border-radius: 5%;
        background-color: rgba(236, 236, 236, .2);
        border: 1px solid rgb(10, 10, 10);
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }
    .Top-div{
        background-color: rgb(30, 30, 30);
        box-shadow: rgba(0, 0, 0, 0.35) 0px -50px 36px -28px inset;
    }
    </style>
</head>

<body>

    <div class = "Top-div">
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("AAPL")["logo"]; ?>">
            <p><?php echo $client->companyProfile2("AAPL")["ticker"]; ?></p>
            <p><?php echo $client->quote("AAPL")["c"]; ?></p>
            <p><?php echo round($client->quote("AAPL")["dp"], 2); ?></p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("AMZN")["logo"]; ?>">
            <p><?php echo $client->companyProfile2("AMZN")["ticker"]; ?></p>
            <p><?php echo $client->quote("AMZN")["c"]; ?></p>
            <p><?php echo round($client->quote("AMZN")["dp"], 2); ?></p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("TSLA")["logo"]; ?>">
            <p><?php echo $client->companyProfile2("TSLA")["ticker"] ; ?></p>
            <p><?php echo $client->quote("TSLA")["c"]; ?></p>
            <p><?php echo round($client->quote("TSLA")["dp"], 2) ?>;</p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("FB")["logo"]; ?>">
            <p><?php echo $client->companyProfile2("FB")["ticker"]; ?></p>
            <p><?php echo $client->quote("FB")["c"]; ?></p>
            <p><?php echo round($client->quote("FB")["dp"], 2) ; ?></p>
        </div>
    </div>

</body>

</html>