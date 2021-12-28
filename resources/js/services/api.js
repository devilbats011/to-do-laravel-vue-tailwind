import { kHeader } from "../constant";

export const serviceGetUserInfo = async () => {
    const token = localStorage.getItem("access_token");
    return await axios({
        method: "get",
        url: "/api/get-the-user",
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
