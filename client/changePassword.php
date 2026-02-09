<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Change password</h1>
    <form>
        <div class="mb-3 mb-15">
            <label for="oldpassword" class="form-label">Old Password</label>
            <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Enter old password">
        </div>
        <div class="visually-hidden" id="newPasswordField">
            <div class="mb-3 mb-15">
                <label for="newpassword" class="form-label">New Password</label>
                <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Enter new password">
            </div>
            <div class="mb-3 mb-15">
                <label for="reenterpassword" class="form-label">Re-enter Password</label>
                <input type="password" class="form-control" name="reenterpassword" id="reenterpassword" placeholder="Enter re-enter password">
            </div>
        </div>
        <div class="text-center">
            <button type="button" onclick="verifyPassFunction(event)" class="btn btn-primary" id="verifyPassBtn">Verify Password</button>
            <button type="button" onclick="updatePassFunction(event)" class="btn btn-primary visually-hidden" id="updatePassBtn">Update Password</button>
        </div>
    </form>
</div>