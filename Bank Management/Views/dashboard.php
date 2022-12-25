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
        background-color: #333;
        color: white;
    }

    table a{
        text-decoration: none;
        color: black;
    }

    .btn-danger{
        color: red;
        padding: 10px;
        border-radius: 5px;
    }

    .btn-danger:hover{
        background-color: red;
    }   

    .btn-info{
        color: lightblue;
        padding: 10px;
        border-radius: 5px;
    }

    .btn-info:hover{
        background-color: lightblue;
    }

    #total-user{
        font-size: x-large;
        color: black;
        padding: 10px;
        border-radius: 5px;
    }   

    .account-info{
        background-color: #333;
        color: white;
        padding: 10px;  
        border-radius: 5px;
        text-align: center;
        
    }
</style>
<body>
    <?php if(isset($_GET["update"])){
        if($_GET["update"] == "fail"){
            echo "Update Failed";
        }
        else{
            echo "Update Successful";
        }
    }
    ?>
    <?php if(isset($_GET["delete"])){
        if($_GET["delete"] == "fail"){ 
            echo "Delete Failed";
        }
        else{
            echo "Delete Successful";
        }
    }
    ?>
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
        <?php if($_SESSION["userRole"] == "admin"){ ?>
            <h1>Welcome <span style="color: tomato;"><?php echo $userInfo['name']; ?></span></h1>
        <?php $users=getAllUsers(); 
        if($users){
            $count = 0;
            foreach($users as $user){
               if($user['accounts_id'] != $userInfo['accounts_id']){
                    $count++;
               }
            }
            if($count > 0){
        ?>
                <h5 id="total-user">Total Accounts Are : <?php echo $count?> </h5>
                <h2>User Details</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th colspan="2">Action</th>
                    </tr>
                    <?php foreach($users as $user) {
                        if($user['id'] != $userInfo['id']){?>
                            <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['sex'];?></td>
                            <td><?php echo $user['email'];?></td>
                            <td><?php echo $user['address'];?></td>
                            <td><?php echo $user['phone'];?></td>
                            <td class="btn-danger"><a href="../Controller/deleteuser.php?id=<?php echo $user['id'];?>">Delete</a></td>
                            <td class="btn-info"><a href="../Views/edituser.php?id=<?php echo $user['id'];?>">Edit</a></td>
                            </tr>
                            <?php
                        }
                        }?>
                </table>
                <?php 
            }
            else{
                echo "No Users Available Right Now";
            }
        }
        else{
            echo "No Users Available Right Now";
        }
        ?>
        <?php }else{ ?>
            <h1 style="text-align: center;">Welcome <?php echo $userInfo['name']; ?></h1>
            <div class="account-info">
                <h5>Your Account Details</h5>
                <h2>Account Number : <?php echo $userInfo['accounts_id'] ?></h2>
                <h3>Your Total Balance Is : <?php echo getBalance($userInfo['accounts_id'])?></h3>
                <?php } ?>
            </div>
    </main>
</body>
</html>