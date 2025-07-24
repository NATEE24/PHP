<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loop for Show Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }
    </style>
</head>

<body>

    <?php
    $products = [
        ['id' => 1001, 'name' => 'Apple', 'price' => 70, 'quantity' => 50],
        ['id' => 1002, 'name' => 'Banana', 'price' => 30, 'quantity' => 100],
        ['id' => 1003, 'name' => 'Orange', 'price' => 45, 'quantity' => 80],
        ['id' => 1004, 'name' => 'Mango', 'price' => 70, 'quantity' => 40],
        ['id' => 1005, 'name' => 'Pineapple', 'price' => 90, 'quantity' => 30],
        ['id' => 1006, 'name' => 'Strawberry', 'price' => 120, 'quantity' => 25],
        ['id' => 1007, 'name' => 'Watermelon', 'price' => 100, 'quantity' => 20],
        ['id' => 1008, 'name' => 'Grapes', 'price' => 85, 'quantity' => 60],
        ['id' => 1009, 'name' => 'Kiwi', 'price' => 110, 'quantity' => 15],
        ['id' => 1010, 'name' => 'Papaya', 'price' => 50, 'quantity' => 35],
        ['id' => 1011, 'name' => 'Guava', 'price' => 70, 'quantity' => 70],
        ['id' => 1012, 'name' => 'Peach', 'price' => 95, 'quantity' => 22],
        ['id' => 1013, 'name' => 'Cherry', 'price' => 130, 'quantity' => 18],
        ['id' => 1014, 'name' => 'Lemon', 'price' => 25, 'quantity' => 90],
        ['id' => 1015, 'name' => 'Blueberry', 'price' => 140, 'quantity' => 12],
    ];
    ?>

    <div class="container mt-5">
        <h1>Product List</h1>

        <form action="" method="post" class="mb-3">
            <div>
                <input type="number" name="price" placeholder="Enter Price" class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <table id="productTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if form submitted
                if (isset($_POST['price'])) {
                    $filterPrice = $_POST['price'];
                    $filteredProducts = array_filter($products, function ($product) use ($filterPrice) {
                        return $product['price'] == $filterPrice;
                    });
                } else {
                    $filteredProducts = $products;
                }

                foreach (array_values($filteredProducts) as $index => $product) {
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . $product['id'] . "</td>";
                    echo "<td>" . $product['name'] . "</td>";
                    echo "<td>" . $product['price'] . "</td>";
                    echo "<td>" . $product['quantity'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#productTable');
    </script>
</body>

</html>