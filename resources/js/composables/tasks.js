import { ref } from "vue";
import axios from "axios";

export default function useTasks() {
    const tasks = ref([]);
    const task = ref({});
    const createdTask = ref({});

    const getToken = () => {
        return {
            headers: {
                Authorization: "Bearer " + sessionStorage.getItem("token"),
            },
        };
    };

    const setFilterSort = (filterSort) => {
        if (filterSort != null) {
            if (
                filterSort.due_date_start != "" &&
                filterSort.due_date_end != ""
            )
                filterSort.due_date =
                    filterSort.due_date_start + "," + filterSort.due_date_end;
            else filterSort.due_date = "";
            if (
                filterSort.date_completed_start != "" &&
                filterSort.date_completed_end != ""
            )
                filterSort.date_completed =
                    filterSort.date_completed_start +
                    "," +
                    filterSort.date_completed_end;
            else filterSort.date_completed = "";
            if (
                filterSort.date_archived_start != "" &&
                filterSort.date_archived_end != ""
            )
                filterSort.date_archived =
                    filterSort.date_archived_start +
                    "," +
                    filterSort.date_archived_end;
            else filterSort.date_archived = "";
        }
        return filterSort;
    };

    const getTasks = async (filterSort = null, url = "/api/tasks/search") => {
        let response = await axios.post(
            url,
            setFilterSort(filterSort),
            getToken()
        );
        tasks.value = response.data.tasks;
    };

    const getTasksCompleted = async (
        filterSort = null,
        url = "/api/tasks/search/completed"
    ) => {
        let response = await axios.post(
            url,
            setFilterSort(filterSort),
            getToken()
        );
        tasks.value = response.data.tasks;
    };

    const getTasksArchives = async (
        filterSort = null,
        url = "/api/tasks/search/archives"
    ) => {
        let response = await axios.post(
            url,
            setFilterSort(filterSort),
            getToken()
        );
        tasks.value = response.data.tasks;
    };

    const selectTask = async (id) => {
        let response = await axios.get("/api/tasks/" + id, getToken());
        task.value = response.data;
    };

    const storeTask = async (form) => {
        let response = await axios.post("/api/tasks", form, getToken());
        createdTask.value = response.data.task;
    };

    const storeTaskTags = async (id, form) => {
        var formData = new FormData();
        formData.append("_method", "PUT");

        for (let i = 0; i < form.length; i++) {
            formData.append("tags[]", form[i]);
        }

        await axios.post("/api/task/tags/" + id, formData, getToken());
    };

    const storeTaskAttachment = async (id, form) => {
        var formData = new FormData();
        formData.append("_method", "PUT");

        for (let i = 0; i < form.length; i++) {
            formData.append("attachments[]", form[i]);
        }

        await axios.post("/api/task/attachments/" + id, formData, {
            headers: {
                Authorization: "Bearer " + sessionStorage.getItem("token"),
                "Content-Type": "multipart/form-data",
            },
        });
    };

    const updateTask = async (id, form) => {
        await axios.put("/api/tasks/" + id, form, getToken());
    };

    const destroyTask = async (id) => {
        await axios.delete("/api/tasks/" + id, getToken());
    };

    const setCompleteTask = async (id) => {
        await axios.get("/api/task/complete/" + id, getToken());
    };

    const setIncompleteTask = async (id) => {
        await axios.get("/api/task/incomplete/" + id, getToken());
    };

    const archiveTask = async (id) => {
        await axios.get("/api/task/archive/" + id, getToken());
    };

    const restoreTask = async (id) => {
        await axios.get("/api/task/restore/" + id, getToken());
    };

    return {
        task,
        tasks,
        createdTask,
        getTasks,
        getTasksArchives,
        getTasksCompleted,
        selectTask,
        storeTask,
        storeTaskTags,
        storeTaskAttachment,
        updateTask,
        destroyTask,
        setCompleteTask,
        setIncompleteTask,
        archiveTask,
        restoreTask,
    };
}
