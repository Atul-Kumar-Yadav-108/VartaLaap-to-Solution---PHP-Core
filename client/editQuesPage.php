<div class="container mt-15 col-12 col-md-5">
    <div id="udpateQuestionPage"></div>
    <div class="d-flex align-items-center position-relative">
        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="fs-2 fs-2 position-absolute start-0"><i class="bi bi-arrow-left-circle-fill"></i></a>
        <h1 class="flex-grow-1 text-center m-0">Update a question</h1>
    </div>
    <form id="createQuestionForm" action="./server/requests.php" method="post">
        <!-- <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>"> -->
        <input type="hidden" name="questionid" id="questionid">
        <div class="mb-3 mb-15">
            <label for="title" class="form-label ">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
        </div>
        <div class="mb-3 mb-15">
            <label for="description" class="form-label ">Description</label>
            <textarea name="description" id="description" cols="30" rows="5" placeholder="Enter description" class="form-control"></textarea>
        </div>
        <!-- <div class="mb-3 mb-15">
            <label for="address" class="form-label ">Category</label>
            <?php

            include("Category.php"); ?>
        </div> -->
        <div class="text-center">
            <!-- <button type="button" onclick="createQuestionfunction(event)" name="askQuesBtn" class="btn btn-primary">Create Question</button> -->
            <button type="submit" name="updateaskQuesBtn" class="btn btn-primary">Update Question</button>
        </div>
    </form>
</div>