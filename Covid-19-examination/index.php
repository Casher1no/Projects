<?php

$limit = 20;
$offset = $_GET['offset'] ?? 0;
$getFrom = $_GET['search-from'] ?? "";
$getTo = $_GET['search-to'] ?? "";

$file = json_decode(file_get_contents("https://data.gov.lv/dati/lv/api/3/action/datastore_search?resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a&limit={$limit}&offset={$offset}"));


// echo "<pre>";
// var_dump($getFrom);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid-19 data</title>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
        background-color: #f2d994;
    }
    </style>
</head>

<body>



    <form method="get" action="/">
        <label for="start">Start date:</label>
        <input type="date" id="start" name="search-from" min="2019-01-01" max="<?php echo date("Y-m-d") ?>">

        <label for="start">End date:</label>
        <input type="date" id="end" name="search-to" min="2019-01-01" max="<?php echo date("Y-m-d") ?>">

        <button type="submit">Submit</button>
    </form>

    <table>
        <thead>
            <th>Date</th>
            <th>Test amount</th>
            <th>Confirmed infections amount</th>
        </thead>

        <?php foreach ($file->result->records as $record): ?>
        <tr>
            <td><?php echo $record->Datums ?></td>
            <td><?php echo $record->TestuSkaits ?></td>
            <td><?php echo $record->ApstiprinataCOVID19InfekcijaSkaits ?></td>
        </tr>

        <?php endforeach; ?>

    </table>
    <form method="get" action="/">
        <?php if ($offset > 0): ?>
            <button type="submit" name="offset" value="<?php echo $offset-$limit; ?>"> << </button>
        <?php endif; ?>

        <?php if (count($file->result->records) >= $limit): ?>
            <button type="submit" name="offset" value="<?php echo $offset+$limit; ?>"> >> </button>
        <?php endif; ?>
    </form>
</body>

</html>