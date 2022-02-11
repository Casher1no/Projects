<?php

use GuzzleHttp\Psr7\Response;

require_once(__DIR__ . '/vendor/autoload.php');

$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c82gr7aad3ia12592efg');
$client = new Finnhub\Api\DefaultApi(
    new GuzzleHttp\Client(),
    $config
);
$search = $_GET["search"];

$tableOfSearch = json_decode(file_get_contents("https://finnhub.io/api/v1/search?q={$search}&token=c82gr7aad3ia12592efg"));

function growColor(float $dp):string
{
    return $dp > 0 ? "rgb(52, 235, 73)" : "rgb(235, 64, 52)";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        
    * {
        margin: auto;
        font-family: 'Roboto', sans-serif;
    }

    body {
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
        color: whitesmoke;
        font-weight: bold;
    }
    table, th, td{
        border: 1px solid black;
        background-color: rgba(236, 236, 236, .2);
    }
    table{
        width: 60%;
    }

    .symbols{
        
    }

    .Stock-bg {
        border-radius: 5%;
        background-color: rgba(236, 236, 236, .2);
        border: 1px solid rgb(10, 10, 10);
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }

    .Top-div {
        background-color: rgb(30, 30, 30);
        box-shadow: rgba(0, 0, 0, 0.35) 0px -50px 36px -28px inset;
    }
    .search-input, .search-button{
        border-radius: 6px;
        padding: 5px;
        border: 2px solid rgb(70, 70, 70);
        background-color: rgba(50, 50, 50, .8);
        color: aliceblue;
    }
    .search-button:hover{
        background-color: rgba(50, 50, 50, .5);
    }
    .AAPL{
        color: <?php echo growColor(round($client->quote("AAPL")["dp"], 2)) ?>;
    }
    .AMZN{
        color: <?php echo growColor(round($client->quote("AMZN")["dp"], 2)) ?>;
    }
    .TSLA{
        color: <?php echo growColor(round($client->quote("TSLA")["dp"], 2)) ?>;
    }
    .FB{
        color: <?php echo growColor(round($client->quote("FB")["dp"], 2)) ?>;
    }
    </style>
</head>

<body>

    <div class="Top-div">
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("AAPL")["logo"]; ?>">
            <p class="symbols"><?php echo $client->companyProfile2("AAPL")["ticker"]; ?></p>
            <p class="price"><?php echo round($client->quote("AAPL")["c"], 2); ?></p>
            <p class="AAPL"><?php echo round($client->quote("AAPL")["dp"], 2); ?></p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("AMZN")["logo"]; ?>">
            <p class="symbols"><?php echo $client->companyProfile2("AMZN")["ticker"]; ?></p>
            <p class="price"><?php echo round($client->quote("AMZN")["c"], 2); ?></p>
            <p class="AMZN"><?php echo round($client->quote("AMZN")["dp"], 2); ?></p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("TSLA")["logo"]; ?>">
            <p class="symbols"><?php echo $client->companyProfile2("TSLA")["ticker"] ; ?></p>
            <p class="price"><?php echo round($client->quote("TSLA")["c"], 2); ?></p>
            <p class="TSLA"><?php echo round($client->quote("TSLA")["dp"], 2); ?></p>
        </div>
        <div class="Stock-bg">
            <img src="<?php echo $client->companyProfile2("FB")["logo"]; ?>">
            <p class="symbols"><?php echo $client->companyProfile2("FB")["ticker"]; ?></p>
            <p class="price"><?php echo round($client->quote("FB")["c"], 2); ?></p>
            <p class="FB"><?php echo round($client->quote("FB")["dp"], 2); ?></p>
        </div>
    </div>

    <div>
        <form method="GET" action="/">
            <input class="search-input" name="search" value="" placeholder="AAPL..."/>
            <button class="search-button" type="submit">Search</button>
        </form>
    </div>
    <div class="search-results">
        <table>
            <thead>
                <th>Description</th>
                <th>Symbol</th>
            </thead>
            <tbody>
                <?php foreach ($tableOfSearch->result as $result): ?>

                    <tr>
                        <td><?php echo $result->description; ?></td>
                        <td><?php echo $result->symbol; ?></td>
                    </tr>

                <?php endforeach ?>    
            </tbody>
        </table>
    </div>

</body>

</html>