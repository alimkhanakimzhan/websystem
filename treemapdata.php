<?php
// Config
require_once "config.php";
?>

<?php require_once(HOME_DIR.'/include/header.php') ?>

<?php
  $payloadStr = $_GET['payload'];
  $data = json_decode(urldecode($payloadStr), true);
?>

<!-- <body> -->
<table class="table table-striped table-bordered table-hover">
    <caption>Список операции FL</caption>

    <thead>
        <tr>
        <th>Transaction_Start_Date</th>
        <th>Sender</th>
        <th>Transaction_End_Date</th>
        <th>Receiver</th>
        <th>Transaction_Type_ID</th>
        <th>Transaction_Amount</th>
        <th>Currency_Type</th>
        <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['Transaction_Start_Date']; ?></td>
            <td><?php echo $row['Sender']; ?></td>
            <td><?php echo $row['Transaction_End_Date']; ?></td>
            <td><?php echo $row['Receiver']; ?></td>
            <td><?php echo $row['Transaction_Type_ID']; ?></td>
            <td><?php echo $row['Transaction_Amount']; ?></td>
            <td><?php echo $row['Currency_Type']; ?></td>
            <td><?php echo $row['Description']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
