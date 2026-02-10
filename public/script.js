const api = "./server/requests.php";
const response_message = document.querySelector("#response_message");

async function signupfunction(e) {
  e.preventDefault();
  const form = document.getElementById("singupForm");
  //  console.log(form);
  const formdata = new FormData(form);
  for (const [key, value] of formdata) {
    // console.log(key, value);
    if (!value.trim()) {
      response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>All fields are required</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
      return;
    }
  }

  formdata.append("task", "signup");

  //  for (const [key,value] of formdata) {
  //     console.log(key,value)
  //  }
  const result = await fetch(api, {
    method: "POST",
    // headers:{
    //     'Content-Type' : 'application/json'
    // },
    // body : JSON.stringify(formdata)
    body: formdata,
  });

  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    response_message.innerHTML = `
  <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show" role="alert">
    <strong>${data.message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
  }
}

async function loginFunction(e) {
  e.preventDefault();
  console.log("entered");
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  if (!email || !password) {
    response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>All fields are required</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
    return;
  }

  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ email: email, password: password, task: "login" }),
  });

  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    response_message.innerHTML = `
  <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show" role="alert">
    <strong>${data.message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
  }
}

//verify password

async function resetPasswordverify(e) {
  e.preventDefault();
  const resetPassField = document.getElementById("reset-pass-field");
  const verifyBtnPassword = document.getElementById("verify-btn-password");
  const resetBtnPassword = document.getElementById("reset-btn-password");
  const email = document.getElementById("email").value.trim();
  const favourite = document.getElementById("favourite").value.trim();
  if (!email || !favourite) {
    response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>All fields are required</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
    return;
  }
  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      email: email,
      favourite: favourite,
      task: "verifyPassword",
    }),
  });

  const data = await result.json();
  if (data.res_status) {
    resetPassField.classList.remove("visually-hidden");
    resetBtnPassword.classList.remove("visually-hidden");
    verifyBtnPassword.classList.add("visually-hidden");
  } else {
    response_message.innerHTML = `
    <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show" role="alert">
      <strong>${data.message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
  }
}

// reset password

async function resetPasswordUpdate(e) {
  e.preventDefault();
  const email = document.getElementById("email").value.trim();
  const favourite = document.getElementById("favourite").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!email || !favourite || !password) {
    response_message.innerHTML = `
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>All fields are required</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
    return;
  }
  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      email: email,
      favourite: favourite,
      password: password,
      task: "updatePassword",
    }),
  });

  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    response_message.innerHTML = `
  <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show" role="alert">
    <strong>${data.message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
  }
}

//verify password
async function verifyPassFunction(e) {
  const oldpassword = document.getElementById("oldpassword").value.trim();
  const newPasswordField = document.getElementById("newPasswordField");
  const updatePassBtn = document.getElementById("updatePassBtn");
  const verifyPassBtn = document.getElementById("verifyPassBtn");
  if (!oldpassword) {
    response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
    <strong>Enter your old password</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
    return;
  }

  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/ json",
    },
    body: JSON.stringify({
      oldpassword: oldpassword,
      task: "verifyPass",
    }),
  });
  const data = await result.json();

  if (data.res_status) {
    verifyPassBtn.classList.add("visually-hidden");
    newPasswordField.classList.remove("visually-hidden");
    updatePassBtn.classList.remove("visually-hidden");
  } else {
    response_message.innerHTML = `
    <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show text-center" role="alert">
      <strong>${data.message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
  }
}

// update password
async function updatePassFunction(e) {
  const newpassword = document.getElementById("newpassword").value.trim();
  const reenterpassword = document
    .getElementById("reenterpassword")
    .value.trim();
  if (!newpassword || !reenterpassword) {
    response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>All fields are required</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
    return;
  }

  if (newpassword !== reenterpassword) {
    response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Password missmatched.Enter Correct password</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
    return;
  }

  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      newpassword: newpassword,
      task: "updatePass",
    }),
  });
  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    response_message.innerHTML = `
    <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show text-center" role="alert">
      <strong>${data.message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
  }
}

async function editProfile(e) {
  e.preventDefault();
  window.location.href = "?editProfile=true";
}

document.addEventListener("DOMContentLoaded", async () => {
  const editForm = document.getElementById("editProfileForm");

  // ❌ edit profile page nahi hai → kuch mat karo
  if (!editForm) return;

  // ✅ edit profile page hai
  const result = await fetch(`${api}?task=getProfile`);
  const data = await result.json();

  if (data.res_status) {
    document.getElementById("username").value = data.user.username;
    document.getElementById("address").value = data.user.address;
    document.getElementById("favourite").value = data.user.favourite;
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
});

document.addEventListener("DOMContentLoaded", async () => {
  const profilePage = document.getElementById("profilePage");

  // ❌ edit profile page nahi hai → kuch mat karo
  if (!profilePage) return;

  // ✅ edit profile page hai
  const result = await fetch(`${api}?task=getProfile`);
  const data = await result.json();

  if (data.res_status) {
    profilePage.innerHTML = `
<table class="table text-center mt-5">
  <tr><th>Username</th><td id="u_name"></td></tr>
  <tr><th>Email</th><td id="u_email"></td></tr>
  <tr><th>Favourite</th><td id="u_fav"></td></tr>
  <tr><th>Address</th><td id="u_addr"></td></tr>
</table>
`;

    document.getElementById("u_name").textContent = data.user.username;
    document.getElementById("u_email").textContent = data.user.email;
    document.getElementById("u_fav").textContent = data.user.favourite;
    document.getElementById("u_addr").textContent = data.user.address;
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
});

// update profile
async function updateProfile(e) {
  const editForm = document.getElementById("editProfileForm");
  const formdata = new FormData(editForm);
  for (const [key, value] of formdata) {
    if (!value.trim()) {
      response_message.innerHTML = `
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Password missmatched.Enter Correct password</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
      return;
    }
  }

  formdata.append("task", "updateProfile");

  const result = await fetch(api, {
    method: "POST",
    body: formdata,
  });

  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    response_message.innerHTML = `
  <div class="alert alert-${data.res_status ? "warning" : "danger"} alert-dismissible fade show" role="alert">
    <strong>${data.message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
`;
  }
}

// profile image icon

const fileInput = document.getElementById("profile");

let selectedFile = null;

// When file selected
if (fileInput !== null) {
  fileInput.addEventListener("change", function () {
    selectedFile = this.files[0];
    const icon = document.getElementById("icon");
    const profileSubmitBtn = document.getElementById("profileSubmitBtn");
    console.log(selectedFile);
    if (selectedFile) {
      // change icon to upload
      // icon.classList.add("visually-hidden");
      icon.setAttribute("title", "Change Profile");
      profileSubmitBtn.classList.remove("visually-hidden");
    }
  });
}
// When upload icon clicked
document.addEventListener("DOMContentLoaded", async function (e) {
  const previewImg = document.getElementById("previewImg");
  if (!previewImg) return;

  e.preventDefault();

  // ✅ edit profile page hai
  const result = await fetch(`${api}?task=getProfileImage`);
  const data = await result.json();

  if (data.res_status) {
    const profile = data.profile
      ? `./public/uploads/${data.profile}`
      : "./discuss.jpg";
    previewImg.setAttribute("src", profile);
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
});

// view questions of respective user
document.addEventListener("DOMContentLoaded", async function () {
  const viewQuestionsPage = document.getElementById("viewQuestionsPage");

  if (!viewQuestionsPage) return;
  // console.log("first");
  Paginations(0);
});

async function Paginations(page) {
  const viewquestionBody = document.getElementById("viewquestionBody");
  const viewQuestionsPagination = document.getElementById(
    "viewQuestionsPagination",
  );
  // let page = 0;
  viewquestionBody.innerHTML = "";
  const result = await fetch(
    `${api}?task=getQuestionsRespectiveUser&page=${encodeURIComponent(page)}`,
  );
  const data = await result.json();
  if (data.res_status) {
    viewquestionBody.innerHTML = "";
    data.questions.forEach((question, index) => {
      viewquestionBody.innerHTML += `
        <tr>
      <td scope="col">${page * 5 + index + 1}</td>
      <td scope="col">${question["title"]}</td>
      <td scope="col">${question["description"].slice(0, 25)}...</td>
      <td scope="col">${question["category"]}</td>
      <td scope="col">
        <a type="button" class="btn btn-info btn-sm text-light" href="?viewPage=true&questionid=${question["id"]}">View</a> 
        <a type="button" class="btn btn-warning btn-sm text-light" href="?editQuesPage=true&questionid=${question["id"]}">Edit</a> 
        <a type="button" class="btn btn-danger btn-sm" href="${api}?task=deleteQuesPage&questionid=${question["id"]}">Delete</a>
      </td>
    </tr>
      `;
    });
    let buttons = ""; // empty string
    for (let index = 0; index <= data.totalPage; index++) {
      buttons += `<button type="button" class="me-1 btn btn-outline-primary ${index == page ? "active" : ""}" onclick="Paginations(${encodeURIComponent(index)})">${index + 1}</button>`;
    }
    viewQuestionsPagination.innerHTML = "";
    viewQuestionsPagination.innerHTML = `
    <tr >
      <td >
      <div class ="text-end px-5">
      <button type="button" class="btn btn-outline-primary ${page == 0 ? "visually-hidden" : ""} inline-block" onclick="Paginations(${encodeURIComponent(page - 1)})">prev</button>
      ${buttons}
      <button type="button" class="btn btn-outline-primary ${data.totalPage == page ? "visually-hidden" : ""}" onclick="Paginations(${encodeURIComponent(page + 1)})">next</button>
      </div>  
    </td>
    </tr>
    `;
  } else {
    viewquestionBody.innerHTML += `
        <tr class="text-center">
        <td scope="col"></td>
        <td scope="col"></td>
        <td scope="col">No Record found</td>
        <td scope="col"></td>
        <td scope="col"></td>
    </tr>
      `;
  }
}

// view question single
// view questions of respective user
document.addEventListener("DOMContentLoaded", async function () {
  const viewQuestionPage = document.getElementById("viewQuestionPage");
  if (!viewQuestionPage) return;
  // console.log(window.location.href.split("questionid=")[1]);
  const result = await fetch(
    `${api}?task=getQuestionRespective&questionid=${window.location.href.split("questionid=")[1]}`,
  );
  const data = await result.json();
  if (data.res_status) {
    // console.log(data.questions);
    viewQuestionPage.innerHTML = `
    <h4 id="ques_title" class="text-primary text-center"></h4>
    <p id="ques_description"></p>
    <h6 id="ques_category"></h6>
    `;
    document.getElementById("ques_title").innerText =
      "Title : " + data.questions["title"];
    document.getElementById("ques_description").innerText =
      "Description : " + data.questions["description"];
    document.getElementById("ques_category").innerText =
      "Category : " + data.questions["category"];
    // console.log(data.comments);

    const commentsDiv = document.getElementById("commentsData");

    let comments = [];

    if (data.comments) {
      comments = Array.isArray(data.comments) ? data.comments : [data.comments];
    }

    if (comments.length === 0) {
      commentsDiv.innerText = "Be first to comment here...";
    } else {
      commentsDiv.innerHTML = "";

      comments.forEach(async (comment) => {
        const div = document.createElement("div");
        div.className = "comment-item mb-2 ms-3";
        const username = await getUsername(comment.user_id);
        // console.log(username);
        const userEl = document.createElement("strong");
        userEl.textContent = username || "Anonymous";

        const br = document.createElement("br");

        const commentEl = document.createElement("span");
        commentEl.className = "ms-2";
        commentEl.textContent = comment.comment; // 👈 script text ban ke dikhega

        div.appendChild(userEl);
        div.appendChild(br);
        div.appendChild(commentEl);

        commentsDiv.appendChild(div);
      });
    }
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
});

//getuser name

async function getUsername(userId) {
  try {
    // console.log(userId);
    // return;
    const response = await fetch(`${api}?task=getUsername&user_id=${userId}`);
    const data = await response.json();

    if (data.res_status) {
      // console.log(data.username);
      return data.username;
    } else {
      return "Anonymous"; // fallback
    }
  } catch (err) {
    console.error(err);
    return "Anonymous"; // fallback on error
  }
}

// scrolling home page

let cursor = null;
let loading = false;
let done = false;

async function loadFeed() {
  if (loading || done) return;
  loading = true;

  let url = api;
  if (cursor) url += "?cursor=" + encodeURIComponent(cursor);

  const res = await fetch(url);
  const data = await res.json();

  if (data.srquestions.length === 0) {
    done = true;
    loading = false;
    document.getElementById("loader").innerText = "No more questions";
    return;
  }

  data.srquestions.forEach((q) => {
    const div = document.createElement("div");
    div.className = "post";
    div.innerHTML = `
      <a href="?viewPage=true&questionid=${q.id}">
        <h3>${q.title}</h3>
      </a>
      <p>${q.description}</p>
    `;
    document.getElementById("feed").appendChild(div);
  });

  cursor = data.nextCursor;
  loading = false;
}

document.addEventListener("DOMContentLoaded", function () {
  const homePage = document.getElementById("homepage");
  if (!homePage) return;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) loadFeed();
    });
  });

  observer.observe(document.getElementById("loader"));
  document.addEventListener("DOMContentLoaded", loadFeed);
});

// comment ans function

// document.getElementById("commentans").addEventListener("click", function (e) {
//   e.preventDefault();
//   const isloggedin = "<?php echo $_SESSION['user'] ? 'true' : 'false'; ?>";
//   if (isloggedin) {
//     console.log("first");
//   }
// });

async function commentFunction(e, isLoggedIn) {
  e.preventDefault();
  // document.getElementById("commentans");
  // const isloggedin = <?php echo $_SESSION['user'] ? 'true' : 'false'; ?>;
  if (!isLoggedIn) {
    window.location.href = "?login=true";
    return;
  }
  const questionId = window.location.href.split("questionid=")[1];
  const comment = document.getElementById("comment").value.trim();
  // console.log(questionId);
  const result = await fetch(api, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      questionId: questionId,
      comment: comment,
      task: "makeComment",
    }),
  });

  const data = await result.json();
  if (data.res_status) {
    window.location.href = data.redirect;
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
}

// visibility of password
function visibilityPassFunction() {
  const passwordType = document.getElementById("password");
  // console.log(passwordType.getAttribute("type"));
  if (passwordType.getAttribute("type") === "password") {
    passwordType.setAttribute("type", "text");
    document.getElementById("eye-close").classList.add("visually-hidden");
    document.getElementById("eye-open").classList.remove("visually-hidden");
  } else {
    passwordType.setAttribute("type", "password");
    document.getElementById("eye-close").classList.remove("visually-hidden");
    document.getElementById("eye-open").classList.add("visually-hidden");
  }
}

// edit askquestion page
document.addEventListener("DOMContentLoaded", async function () {
  const udpateQuestionPage = document.getElementById("udpateQuestionPage");
  if (!udpateQuestionPage) return;
  const questionId = window.location.href.split("questionid=")[1];

  const result = await fetch(
    `${api}?task=updateQuest&questionId=${questionId}`,
  );

  const data = await result.json();
  // console.log(window.location.href.split("questionid=")[1]);
  if (data.res_status) {
    // console.log(data.question);
    document.getElementById("title").value = data.question.title;
    document.getElementById("questionid").value = data.question.id;
    document.getElementById("description").innerText =
      data.question.description;
  } else {
    document.getElementById("response_message").innerHTML = `
      <div class="alert alert-danger">${data.message}</div>
    `;
  }
});

// search file
async function searchBtnFunction(e) {
  e.preventDefault();
  const searchData = document.getElementById("search").value;
  if (!searchData) {
    window.location.href = "../discuss";
    return;
  }
  window.location.href = `?searchPage=true&search=${encodeURIComponent(searchData)}`;
}

document.addEventListener("DOMContentLoaded", async function () {
  const searchPage = document.getElementById("searchPage");
  if (searchPage) {
    // const searchData = document.getElementById("search").value;
    const searchData = window.location.href.split("search=")[1];
    console.log(searchData);
    const result = await fetch(
      `${api}?task=searchData&search=${encodeURIComponent(searchData)}`,
    );
    const data = await result.json();
    if (data.res_status) {
      if (data.searchResult.length > 0) {
        console.log(data.searchResult);
        document.getElementById("feed").innerHTML = "";
        data.searchResult.forEach((q) => {
          const div = document.createElement("div");
          div.className = "post";
          div.innerHTML = `
      <a href="?viewPage=true&questionid=${q.id}">
        <h3>${q.title}</h3>
      </a>
      <p>${q.description}</p>
    `;
          document.getElementById("feed").appendChild(div);
        });
      } else {
        document.getElementById("feed").innerHTML = `
      <p class="text-primary">Search : ${searchData}</p>
      <h3>No record found</h3>
      `;
      }
    }
  }
});
