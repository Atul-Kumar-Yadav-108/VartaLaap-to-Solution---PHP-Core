<div class="container mt-15 col-12 col-md-5">
    <h1 class="text-center">Profile</h1>
    <div class="container">
        <div class="image text-center rounded-circle">
            <img src="./discuss.jpg" alt=" profile" width="100px" class="rounded-circle m-0 p-0" id="previewImg">
            <form action="./server/requests.php" class="m-0 p-0" method="post" enctype="multipart/form-data">
                <label for="profile" style="cursor:pointer;">
                    <i id="icon" class="bi bi-plus-circle text-primary"></i>
                </label>
                <input type="file" name="profile" id="profile" accept="image/*" hidden>
                <button type="submit" class="btn fs-3 bi bi-upload text-success visually-hidden mt-0 pt-0 pb-3" id="profileSubmitBtn" name="profileSubmitBtn" title="upload image"></button>
            </form>
        </div>
        <div id="profilePage">

        </div>

        <div class="editprofile text-center">
            <button type="button" class="btn btn-primary" onclick="editProfile(event)">Edit profile</button>
        </div>
    </div>
</div>