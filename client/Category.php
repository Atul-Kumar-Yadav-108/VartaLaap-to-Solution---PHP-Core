<select name="category" id="category" class="form-control dropdown">
    <option value="">Select Category</option>
    <?php
    include("./common/db.php");
    $catStmt = $con->query("Select * from categories");
    $categories = $catStmt->fetch_all(MYSQLI_ASSOC);
    foreach ($categories as $category) {
    ?>
        <option value="<?php echo $category['category'] ?>"><?php echo ucfirst($category['category']) ?></option>
    <?php
    }

    ?>
</select>