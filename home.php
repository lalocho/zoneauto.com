<?php
include_once "connect.php";


// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

    //exit;
}
// For extra protection these are the columns of which the user can sort by (in your database table).
$columns = array('PartID','PartName','PartNumber','Suppliers','Category','Description01',
    'Description02','Description03','Description04','Description05','Description06','Price','Estimated Shipping Cost','Shipping Weight');

// Only get the column if it exists in the above columns array, if it doesn't exist the database table will be sorted by the first item in the columns array.
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];

// Get the sort order for the column, ascending or descending, default is ascending.
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

// Get the result...
if ($result = $link->query('SELECT * FROM carparts ORDER BY ' .  $column . ' ' . $sort_order)) {
    // Some variables we need for the table.
    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="highlight"';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>PHP & MySQL Table Sorting by CodeShack</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            ?><a href="login.php" class="btn btn-warning">Login</a>
            <?php
        }else{
            ?>
            <a href="logout.php" class="btn btn-warning">Logout</a>
            <?php
        }
        ?>
        <style>
            html {
                font-family: Tahoma, Geneva, sans-serif;
                padding: 10px;
            }
            table {
                border-collapse: collapse;
                width: 500px;
            }
            th {
                background-color: #54585d;
                border: 1px solid #54585d;
            }
            th:hover {
                background-color: #64686e;
            }
            th a {
                display: block;
                text-decoration:none;
                padding: 10px;
                color: #ffffff;
                font-weight: bold;
                font-size: 13px;
            }
            th a i {
                margin-left: 5px;
                color: rgba(255,255,255,0.4);
            }
            td {
                padding: 10px;
                color: #636363;
                border: 1px solid #dddfe1;
            }
            tr {
                background-color: #ffffff;
            }
            tr .highlight {
                background-color: #f9fafb;
            }
        </style>
    </head>
    <body>
    <table>
        <tr>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Part ID<i class="fas fa-sort<?php echo $column == 'PartID' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=age&order=<?php echo $asc_or_desc; ?>">PartName<i class="fas fa-sort<?php echo $column == 'PartName' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=joined&order=<?php echo $asc_or_desc; ?>">PartNumber<i class="fas fa-sort<?php echo $column == 'PartNumber' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Suppliers<i class="fas fa-sort<?php echo $column == 'Suppliers' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Category<i class="fas fa-sort<?php echo $column == 'Category' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description01<i class="fas fa-sort<?php echo $column == 'Description01' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description02<i class="fas fa-sort<?php echo $column == 'Description02' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description03<i class="fas fa-sort<?php echo $column == 'Description03' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description04<i class="fas fa-sort<?php echo $column == 'Description04' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description05<i class="fas fa-sort<?php echo $column == 'Description05' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Description06<i class="fas fa-sort<?php echo $column == 'Description0' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Price<i class="fas fa-sort<?php echo $column == 'Price' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Estimated Shipping Cost<i class="fas fa-sort<?php echo $column == 'Estimated Shipping Cost' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="home.php?column=name&order=<?php echo $asc_or_desc; ?>">Shipping Weight<i class="fas fa-sort<?php echo $column == 'Shipping Weight' ? '-' . $up_or_down : ''; ?>"></i></a></th>

        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td<?php echo $column == 'PartID' ? $add_class : ''; ?>><?php echo $row['PartID']; ?></td>
                <td<?php echo $column == 'PartName' ? $add_class : ''; ?>><?php echo $row['PartName']; ?></td>
                <td<?php echo $column == 'PartNumber' ? $add_class : ''; ?>><?php echo $row['PartNumber']; ?></td>
                <td<?php echo $column == 'Suppliers' ? $add_class : ''; ?>><?php echo $row['Suppliers']; ?></td>
                <td<?php echo $column == 'Category' ? $add_class : ''; ?>><?php echo $row['Category']; ?></td>
                <td<?php echo $column == 'Description01' ? $add_class : ''; ?>><?php echo $row['Description01']; ?></td>
                <td<?php echo $column == 'Description02' ? $add_class : ''; ?>><?php echo $row['Description02']; ?></td>
                <td<?php echo $column == 'Description03' ? $add_class : ''; ?>><?php echo $row['Description03']; ?></td>
                <td<?php echo $column == 'Description04' ? $add_class : ''; ?>><?php echo $row['Description04']; ?></td>
                <td<?php echo $column == 'Description05' ? $add_class : ''; ?>><?php echo $row['Description05']; ?></td>
                <td<?php echo $column == 'Description06' ? $add_class : ''; ?>><?php echo $row['Description06']; ?></td>
                <td<?php echo $column == 'Price' ? $add_class : ''; ?>><?php echo $row['Price']; ?></td>
                <td<?php echo $column == 'Estimated Shipping Cost' ? $add_class : ''; ?>><?php echo $row['Estimated Shipping Cost']; ?></td>
                <td<?php echo $column == 'Shipping Weight' ? $add_class : ''; ?>><?php echo $row['Shipping Weight']; ?></td>


            </tr>
        <?php endwhile; ?>
    </table>
    </body>
    </html>
    <?php
    $result->free();
}
?>