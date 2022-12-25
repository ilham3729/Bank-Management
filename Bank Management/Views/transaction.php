<?php
    session_start();
    require_once "../Middleware/userUtils.php";
    require_once "../Middleware/accountUtils.php";
    $role = "";
    $userInfo=array();
    if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $userInfo = getUserAllInfo($userId);
        $role = getUserRole($userId);
        $_SESSION["userInfo"] = $userInfo;
        $_SESSION["userRole"] = $role;
    }
    else{
        header("Location: ../index.php");
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<style>
    header{
        background-color: #333;
        overflow: hidden;
    }
    header a{
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }
    header a:hover{
        background-color: #ddd;
        color: black;
    }
    header a.active{
        background-color: #4CAF50;
        color: white;
    }
    header a.logout{
        float: right;
    }
    main{
        margin-top: 50px;
    }

    h1{
        text-align: center;
    }

    span{
        float: right;
    }

    span a{
        text-decoration: none;
        color: blue;
    }

    span a:hover{
        color: red;
    }   

    p{
        font-size: 20px;
    }
    
    table{
        border-collapse: collapse;
        width: 100%;
    }   

    th, td{
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th{
        background-color: #4CAF50;
        color: white;
    }   

</style>
<body>
    <header>
        <a href="../Views/dashboard.php">Dashboard</a>
        <a href="../Views/profile.php">Profile</a>
        <?php if($_SESSION["userRole"] == "admin"){ ?>
            <a href="../Views/register.php">Add User</a>
        <?php }else{ ?>
            <a href="../Views/deposite.php">Deposite Money</a>
            <a href="../Views/withdraw.php">Withdraw Money</a>
            <a href="../Views/transfer.php">Transfer Money</a>
            <a href="../Views/transaction.php">See All Transaction</a>
        <?php } ?>
        <a href="../Controller/logout.php">Logout</a>
    </header>
    <main>
        <h1>All Transactions</h1>
        <?php 
            $deposit = getAllDeposites($userInfo["accounts_id"]);
            $withdraw = getAllWithdraws($userInfo["accounts_id"]);
            $transfer = getAllTransfers($userInfo["accounts_id"]);
            $numberOfDeposites = count($deposit);
            $numberOfWithdraws = count($withdraw);
            $numberOfTransfers = count($transfer);
            $amountOfDeposites = 0;
            $amountOfWithdraws = 0;
            $amountOfTransfers = 0;
            for($i=0;$i<$numberOfDeposites;$i++){
                $amountOfDeposites += $deposit[$i]["amount"];
            }
            for($i=0;$i<$numberOfWithdraws;$i++){
                $amountOfWithdraws += $withdraw[$i]["amount"];
            }
            for($i=0;$i<$numberOfTransfers;$i++){
                $amountOfTransfers += $transfer[$i]["amount"];
            }
        ?>
        <h2>Total Deposite: <?php echo $numberOfDeposites;?> Times</h2>
        <h2>Total Withdraw: <?php echo $numberOfWithdraws;?> Times</h2>
        <h2>Total Transfer: <?php echo $numberOfTransfers;?> Times</h2>
        <h2>Total Deposite: <?php echo $amountOfDeposites;?> BDT</h2>
        <h2>Total Withdraw: <?php echo $amountOfWithdraws;?> BDT</h2>
        <h2>Total Transfer: <?php echo $amountOfTransfers;?> BDT</h2>
        <table border="1px">
            <tr>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Account Number</th>
            </tr>
            <?php foreach($deposit as $deposit){ ?>
                <tr>
                    <td>Deposit</td>
                    <td><?php echo $deposit['amount']; ?></td>
                    <td><?php echo $deposit['deposite_at']; ?></td>
                    <td><?php echo $deposit['account_number']; ?></td>
                </tr>
            <?php } ?>
            <?php foreach($withdraw as $withdraw){ ?>
                <tr>
                    <td>Withdraw</td>
                    <td><?php echo $withdraw['amount']; ?></td>
                    <td><?php echo $withdraw['withdraw_at']; ?></td>
                    <td><?php echo $withdraw['account_number']; ?></td>
                </tr>
            <?php } ?>
            <?php foreach($transfer as $transfer){ ?>
                <tr>
                    <td>Transfer</td>
                    <td><?php echo $transfer['amount']; ?></td>
                    <td><?php echo $transfer['transfer_at']; ?></td>
                    <td><?php echo $transfer['to_account_number']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>