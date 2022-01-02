import { kHeader } from "../constant";

const token = localStorage.getItem("access_token");
export const serviceGetUserInfo = async () => {
    return await axios({
        method: "get",
        url: "/api/user",
        headers: { ...kHeader, Authorization: `${token}` },
    })
    .then(function (content) {
            return {
                name: content.data.name,
                username: content.data.username,
                user_type: content.data.user_type,
            };
        })
        .catch(function (err) {
            console.error(err);
        });
}

export const checkCreate = async (thisVue,pageName="") => {
    fetch("/api/todos/create", {
        method: "get",
        headers: { ...kHeader, Authorization: `${token}` },
    })
    .then(async (rawContent) => {
        const content = await rawContent.json();
        const checkTodoCount = content["check-todo-count"];
            console.log("xx", content);
        if (rawContent.status == 403) {
            let tempString = checkTodoCount.permission;
            const message = checkTodoCount.message;
            if (tempString.toUpperCase() === "DENIED") {
                const redirect = checkTodoCount.redirect;
                thisVue.$router.push({ path: "/" + redirect,query:{alertMessage:message} });
                return null;
            }
        }
        else if(rawContent.status == 200){
            let tempString = checkTodoCount.permission;
            if (tempString.toUpperCase() === "ALLOW") {
                const to = checkTodoCount.to;
                if(pageName != to)
                    thisVue.$router.push({ path: "/" + to  } );
                return null;
            }
        }
    })
    .catch((err) => {
        console.error(err);
    });
}
