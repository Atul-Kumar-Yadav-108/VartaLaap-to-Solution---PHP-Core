<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Sign up</h1>
    <form id="singupForm">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <div class="mb-3 mb-15">
            <label for="username" class="form-label ">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
        </div>
        <div class="mb-3 mb-15">
            <label for="email" class="form-label ">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
        </div>
        <div class="mb-3 mb-15">
            <label for="password" class="form-label ">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
        </div>
        <div class="mb-3 mb-15">
            <label for="address" class="form-label ">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Enter address">
        </div>
        <div class="mb-3 mb-15">
            <label for="favoruite" class="form-label ">Favourite Question</label>
            <input type="text" class="form-control" name="favourite" id="favourite" placeholder="eg. cityname, birthplace, fav player etc">
        </div>
        <div class="text-center">
            <button type="button" onclick="signupfunction(event)" class="btn btn-primary">Sign up</button>
        </div>
    </form>
</div>