<?php

$search=implode($_GET);
$offset = $_GET['offset'] ?? 0;
$limit = 50;
$file = json_decode(file_get_contents("https://data.gov.lv/dati/lv/api/3/action/datastore_search?q={$search}&offset={$offset}&resource_id=25e80bf3-f107-4ab4-89ef-251b5b9374e9&limit={$limit}"));
$table=[];

foreach ($file as $a) {
    $table[] = $a;
}
$data = $table[2];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practise</title>
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
        <input name="search" value="" />
        <button type="submit">Submit</button>
    </form>

    <h2>Companys table</h2>
    <table>
        <thead>
            <th>Name</th>
            <th>Registration number</th>
            <th>Company type</th>
        </thead>
        <tbody>
            <?php foreach ($data->records as $d) :?>

            <tr>
                <td><?php echo $d->name;?></td>
                <td><?php echo $d->regcode;?></td>
                <td><?php echo $d->type;?></td>
            </tr>

            <?php endforeach;?>
        </tbody>
    </table>

    <form method="get" action="/">
        <?php if ($offset > 0): ?>
            <button type="submit" name="offset" value="<?php echo $offset-$limit; ?>"> << </button>
        <?php endif; ?>

        <?php if (count($data->records) >= $limit): ?>
            <button type="submit" name="offset" value="<?php echo $offset+$limit; ?>"> >> </button>
        <?php endif; ?>
    </form>


</body>

</html>