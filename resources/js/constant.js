export  const kHeader = {
    "Accept": "application/json",
    "Content-Type": "application/json",
    "Cache-Control": "no-cache",
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : window.Laravel.csrfToken,
    
}
// function handleLoginAxios() {
//     this.loginDisabled = true;
//     this.errorMessage = "";
//     const formData = new FormData();
//     formData.append("email_or_username", this.email_or_username);
//     formData.append("password", this.password);

//     console.log(
//       "password",
//       this.password,
//       "email_or_username",
//       this.email_or_username
//     );
//     const router = this.$router;

//     axios({
//       method: "post",
//       url: `/api/login?timestamp=${new Date().getTime()}`,
//       data: formData,
//       headers: {
//         'X-Requested-With': 'XMLHttpRequest',
//         'X-CSRF-TOKEN' : window.Laravel.csrfToken,
//         "Accept": "application/json",
//         "Cache-Control": "no-cache",
//       },
//     })
//       .then(function (res) {
//         if (res.status == 200) {
//           console.log(res.data.to, "too");

//           localStorage.setItem(
//             "access_token",
//             `Bearer ${res.data.access_token}`
//           );
//           router.push({ path: "/" + res.data.to });
//         }
//       })
//       .catch((err) => {
//         this.errorMessage = "Invalid Credentials";
//         if (err.response !== undefined) {
//           console.warn("error.respond", err.response);
//           this.errorMessage = err.response.data.message;
//         }
//         console.error("error", err);
//       })
//       .finally(() => {
//         this.loginDisabled = false;
//       });
//   }


