<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Reset your password</h1>
    <form>
        <div class="mb-3 mb-15">
            <label for="email" class="form-label ">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
        </div>
        <div class="mb-3 mb-15">
            <label for="favoruite" class="form-label ">Favourite Question</label>
            <input type="text" class="form-control" name="favourite" id="favourite" placeholder="eg. cityname, birthplace, fav player etc">
        </div>
        <div class="mb-3 mb-15 visually-hidden position-relative" id="reset-pass-field">
            <label for="password" class="form-label ">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            <span class="password-toggle position-absolute pt-4 top-50 end-0 translate-middle-y me-3" onclick="visibilityPassFunction()">
                <i type="button" class="bi bi-eye-slash-fill fs-5" id="eye-close"></i>
                <i type="button" class="bi bi-eye-fill fs-5 visually-hidden" id="eye-open"></i>
            </span>
        </div>
        <div class="text-center">
            <button type="button" onclick="resetPasswordverify(event)" id="verify-btn-password" class="btn btn-primary">Verify</button>
            <button type="button" onclick="resetPasswordUpdate(event)" id="reset-btn-password" class="btn btn-primary visually-hidden">Reset</button>
        </div>
        <div class="text-center">
            <a href="?login=true" class="text-info">Login</a>
        </div>
    </form>
</div>