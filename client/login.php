<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Login</h1>
    <form>
        <div class="mb-3 mb-15">
            <label for="email" class="form-label ">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
        </div>
        <!-- <div class="mb-3 mb-15">
            <label for="password" class="form-label position-relative">Password</label>
            <div class="hideUnhidepass position-absolute end-50">
                <i class="bi bi-eye-slash-fill fs-4"></i>
                <i class="bi bi-eye-fill fs-4"></i>
            </div>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
        </div> -->

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>

            <input
                type="password"
                class="form-control pe-5"
                name="password"
                id="password"
                placeholder="Enter password">

            <span class="password-toggle position-absolute pt-4 top-50 end-0 translate-middle-y me-3" onclick="visibilityPassFunction()">
                <i type="button" class="bi bi-eye-slash-fill fs-5" id="eye-close"></i>
                <i type="button" class="bi bi-eye-fill fs-5 visually-hidden" id="eye-open"></i>
            </span>
        </div>
        <div class="text-center">
            <button type="button" onclick="loginFunction(event)" class="btn btn-primary">Login</button>
        </div>
        <div class="text-center">
            <a href="?resetPassword=true" class="text-info">Forgot Password? Reset your password</a>
        </div>
    </form>
</div>

<script>

</script>