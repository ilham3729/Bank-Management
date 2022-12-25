<?php
    session_start();
    require_once "../Middleware/accountUtils.php";
    $role = "";
    $userInfo=array();
    if(isset($_SESSION['userId'])){
        $role= $_SESSION['userRole'];
        $userId = $_SESSION['userId'];
        $userInfo = $_SESSION["userInfo"];
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

    a{
        text-decoration: none;
        color: blue;
    }   

    a:hover{
        color: red;
    }

    form{
        margin: 0 auto;
        width: 50%;
    }

    form input{
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    form input[type=submit]{
        background-color: #4CAF50;
        color: white;
        border: none;
    }

    form input[type=submit]:hover{
        opacity: 0.8;
    }

    form label{
        font-size: 20px;
    }

    form p{
        font-size: 20px;
    }   

    form p a{
        color: blue;
    }   

    form p a:hover{
        color: red;
    }   

    form p span{
        float: right;
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
        <?php include "../Controller/transfer.php"; ?>
        <h1>Withdraw Money</h1>
        <?php if(isset($message)){ ?>
            <p style="text-align: center; color: red;"><?php echo $message; ?></p>
        <?php } ?>
        <form action="" method="POST">
            <label for="to_accountNumber">Reciver Account Number</label>
            <input type="number" name="to_accountNumber" id="to_accountNumber">
            <?php if(isset($errors["to_accountNumber"])){ ?>
                <?php echo $errors["to_accountNumber"]; ?>
            <?php } ?>
            <br>

            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount">
            <?php if(isset($errors["amount"])){ ?>
                <span><?php echo $errors["amount"]; ?></span>
            <?php } ?>
            <br>

            <input type="submit" name="transfer" value="Transfer">
        </form>
    </main>
</body>
</html>