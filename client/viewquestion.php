<div class="container mt-15 col-12 col-md-6">
    <h1 class="text-center">View Question</h1>
    <hr>
    <div id="viewQuestionPage">

    </div>
    <hr>
    <form>
        <?php
        $isLoggedIn = isset($_SESSION['user']) ? "true" : "false";
        ?>
        <h5 class="">Comments</h5>
        <div class="mb-3 mb-15">
            <textarea name="comment" id="comment" cols="30" rows="3" placeholder="Write your comment" class="form-control"></textarea>
        </div>
        <div class="">
            <!-- <button type="button" onclick="createQuestionfunction(event)" name="askQuesBtn" class="btn btn-primary">Create Question</button> -->
            <button type="button" name="commentans" onclick="commentFunction(event,<?php echo $isLoggedIn ?>)" class="btn btn-primary">Answer <i class="bi bi-arrow-right-circle-fill"></i></button>
        </div>
    </form>
    <hr>
    <div id="commentsData">

    </div>
</div>