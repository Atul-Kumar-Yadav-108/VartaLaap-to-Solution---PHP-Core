<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Ask a question</h1>
    <form id="createQuestionForm" action="./server/requests.php" method="post">
        <!-- <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>"> -->

        <div class="mb-3 mb-15">
            <label for="title" class="form-label ">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
        </div>
        <div class="mb-3 mb-15">
            <label for="description" class="form-label ">Description</label>
            <textarea name="description" id="description" cols="30" rows="5" placeholder="Enter description" class="form-control"></textarea>
        </div>
        <div class="mb-3 mb-15">
            <label for="address" class="form-label ">Category</label>
            <?php

            include("Category.php"); ?>
        </div>
        <div class="text-center">
            <!-- <button type="button" onclick="createQuestionfunction(event)" name="askQuesBtn" class="btn btn-primary">Create Question</button> -->
            <button type="submit" name="askQuesBtn" class="btn btn-primary">Create Question</button>
        </div>
    </form>
</div>