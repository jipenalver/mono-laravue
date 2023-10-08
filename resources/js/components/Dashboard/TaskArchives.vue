<template>
    <TopNav />
    <SideNav />

    <main id="main"
          class="main">

        <div class="pagetitle">
            <h1>
                <i class="bi bi-card-checklist"></i> Archived Tasks
            </h1>
            <br>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Archived Tasks</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3">

                                <div class="col-lg-4">
                                    <label for="basic-url"
                                           class="form-label fw-bold">Due Date:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">From:</span>
                                        <input type="date"
                                               v-model="filterSort.due_date_start"
                                               class="form-control">
                                        <span class="input-group-text">To:</span>
                                        <input type="date"
                                               v-model="filterSort.due_date_end"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="basic-url"
                                           class="form-label fw-bold">Date Completed:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">From:</span>
                                        <input type="date"
                                               v-model="filterSort.date_completed_start"
                                               class="form-control">
                                        <span class="input-group-text">To:</span>
                                        <input type="date"
                                               v-model="filterSort.date_completed_end"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="basic-url"
                                           class="form-label fw-bold">Date Archived:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">From:</span>
                                        <input type="date"
                                               v-model="filterSort.date_archived_start"
                                               class="form-control">
                                        <span class="input-group-text">To:</span>
                                        <input type="date"
                                               v-model="filterSort.date_archived_end"
                                               class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-3">
                                    <input type="text"
                                           v-model="filterSort.keyword"
                                           class="form-control mt-2"
                                           placeholder="Search Title or Description...">
                                </div>
                                <div class="col-lg-2">
                                    <select class="form-select mt-2"
                                            v-model="filterSort.priority">
                                        <option value=""
                                                selected>Choose Priority...</option>
                                        <option value="Urgent">Urgent</option>
                                        <option value="High">High</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <h5 class="mt-3">Sort:</h5>
                                </div>
                                <div class="col-lg-2">
                                    <select class="form-select mt-2"
                                            v-model="filterSort.column">
                                        <option value="id"
                                                selected>Choose...</option>
                                        <option value="title">Title</option>
                                        <option value="description">Description</option>
                                        <option value="priority">Priority</option>
                                        <option value="due_date">Due Date</option>
                                        <option value="created_at">Created Date</option>
                                        <option value="date_completed">Completed Date</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="form-select mt-2"
                                            v-model="filterSort.order">
                                        <option value="asc"
                                                selected>Choose Order...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button"
                                            class="btn btn-secondary w-100 mt-2 fw-bold"
                                            @click="getTasksArchives(filterSort)">
                                        <i class="bi bi-search"></i>
                                        Filter
                                    </button>
                                </div>

                            </div>

                            <hr>

                            <!-- On my home page, I want to see a list of all my tasks in a card list view. -->
                            <template v-for="task in tasks.data"
                                      :key="task.id">

                                <div class="card">
                                    <div class="card-header">
                                        <span class="fw-bold"><i class="bi bi-pin-angle"></i> {{ task.title }}</span>

                                        <div class="btn-group float-end"
                                             role="group">
                                            <button type="button"
                                                    class="btn btn-primary dropdown-toggle fw-bold"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="bi bi-caret-down"></i>
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item with-pointer"
                                                       @click="setTaskRestore(task.id)">
                                                        <i class="bi bi-arrow-90deg-down"></i> Restore Task
                                                    </a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="modal"
                                                       data-bs-target="#confirmModal"
                                                       @click="deleteAction(task.id)"
                                                       class="dropdown-item">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="card-body with-pointer"
                                         data-bs-toggle="modal"
                                         data-bs-target="#taskModal"
                                         @click="viewAction(task.id)">

                                        <div class="row">
                                            <div class="col-sm-12 col-lg-9">

                                                <p class="card-text mt-3">{{ task.description }}</p>
                                                <p v-if="typeof task?.tags === 'string'">
                                                    <span class="text-primary with-pointer"
                                                          v-for="item in task.tags.split(',')">
                                                        {{ '#' + item }}
                                                        &nbsp;
                                                    </span>
                                                </p>
                                                <template v-if="typeof task?.attachments === 'string'">
                                                    <small><b>Attachments:</b></small>
                                                    <ul>
                                                        <li v-for="item in task.attachments.split(',')">
                                                            <a :href="'storage/' + item"
                                                               target="_blank">
                                                                {{ item.replace('attachments/', '') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </template>

                                            </div>
                                            <div class="col-sm-12 col-lg-3 pt-3">

                                                <p class="me-5 fw-bold">
                                                    Status:
                                                    <span v-if="task.date_archived != null"
                                                          class="text-danger">
                                                        <i class="bi bi-trash"></i>
                                                        Archived
                                                    </span>
                                                    <span v-else-if="task.date_completed != null"
                                                          class="text-success">
                                                        <i class="bi bi-check-circle"></i>
                                                        Completed
                                                    </span>
                                                    <span v-else
                                                          class="text-warning">
                                                        Incomplete
                                                    </span>
                                                </p>
                                                <p class="me-5 fw-bold">
                                                    Priority:
                                                    <span v-if="task.priority == 'Urgent'"
                                                          class="badge bg-danger">
                                                        Urgent
                                                    </span>
                                                    <span v-else-if="task.priority == 'High'"
                                                          class="badge bg-warning text-dark">
                                                        High
                                                    </span>
                                                    <span v-else-if="task.priority == 'Normal'"
                                                          class="badge bg-info text-dark">
                                                        Normal
                                                    </span>
                                                    <span v-else-if="task.priority == 'Low'"
                                                          class="badge bg-light text-dark">
                                                        Low
                                                    </span>
                                                </p>
                                                <p class="me-5 fw-bold">
                                                    Due Date:
                                                    <span class="fw-bold text-danger">
                                                        {{ task.due_date }}
                                                    </span>
                                                </p>
                                                <p class="me-5 fw-bold">
                                                    Date Completed:
                                                    <span class="fw-bold text-success">
                                                        {{ task.date_completed }}
                                                    </span>
                                                </p>
                                                <p class="me-5 fw-bold">
                                                    Date Archived:
                                                    <span class="fw-bold">
                                                        {{ task.date_archived }}
                                                    </span>
                                                </p>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </template>
                            <!-- End Card List Todos -->

                            <!-- Centered Pagination -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <template v-for="link in tasks.links">

                                        <li class="page-item with-pointer"
                                            :class="{ 'disabled': link.url == null, 'active': link.active == true }">
                                            <a @click="getTasksArchives(filterSort, link.url)"
                                               class="page-link">
                                                <span v-html="link.label"></span>
                                            </a>
                                        </li>

                                    </template>
                                </ul>
                            </nav>
                            <!-- End Centered Pagination -->

                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>
    <!-- End #main -->

    <FooterNav />

    <!-- Task Modal -->
    <div class="modal fade"
         id="taskModal"
         tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i>
                        {{ action.type == 'Create' ? 'Create Task' : 'Task Information' }}
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <form @submit.prevent="saveTask"
                      novalidate>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText"
                                   class="col-sm-2 col-form-label">Title:</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       v-model="form.title"
                                       :class="{ 'is-invalid': action.errors.title }"
                                       class="form-control">
                                <div v-if="action.errors.title"
                                     class="invalid-feedback">
                                    {{ action.errors.title[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText"
                                   class="col-sm-2 col-form-label">Description:</label>
                            <div class="col-sm-10">
                                <input type="text"
                                       v-model="form.description"
                                       :class="{ 'is-invalid': action.errors.description }"
                                       class="form-control">
                                <div v-if="action.errors.description"
                                     class="invalid-feedback">
                                    {{ action.errors.description[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDate"
                                   class="col-sm-2 col-form-label">Due Date:</label>
                            <div class="col-sm-10">
                                <datepicker v-model="form.date_picker"
                                            class="form-control"
                                            :class="{ 'is-invalid': action.errors.due_date || action.type == 'Due' }" />
                                <small v-if="action.errors.due_date"
                                       class="text-danger">
                                    {{ action.errors.due_date[0] }}
                                </small>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Priority:</label>
                            <div class="col-sm-10">
                                <select class="form-select"
                                        :class="{ 'is-invalid': action.errors.priority }"
                                        aria-label="Task Priority"
                                        v-model="form.priority">
                                    <option value=""
                                            selected>-</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="High">High</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Low">Low</option>
                                </select>
                                <div v-if="action.errors.priority"
                                     class="invalid-feedback">
                                    {{ action.errors.priority[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText"
                                   class="col-sm-2 col-form-label">Tags:</label>
                            <div class="col-sm-10">
                                <vue3-tags-input :tags="taskTags"
                                                 :class="{ 'is-invalid': action.errors.tags }"
                                                 @on-tags-changed="handleTags" />
                                <div v-if="action.errors.tags"
                                     class="invalid-feedback">
                                    {{ action.errors.tags[0] }}
                                </div>
                            </div>
                        </div>
                        <div v-if="form.tags.length >= 1 && action.type == 'View'"
                             class="row mb-3">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <template v-for="item in form.tags">
                                    <span class="text-primary with-pointer">
                                        {{ '#' + item }}
                                        &nbsp;
                                    </span>
                                </template>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber"
                                   class="col-sm-2 col-form-label">
                                Attachment/s:
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control"
                                       :class="{ 'is-invalid': action.errors.message != null }"
                                       ref="taskAttachments"
                                       @change="handleAttachments"
                                       type="file"
                                       multiple>
                                <div v-if="action.errors"
                                     class="invalid-feedback">
                                    {{ action.errors.message ??= action.errors.attachments }}
                                </div>
                            </div>
                        </div>
                        <div v-if="form.attachments.length >= 1 && action.type == 'View' && (typeof form.attachments[0] !== 'object')"
                             class="row mb-3">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <ul>
                                    <li v-for="item in form.attachments">
                                        <a :href="'storage/' + item"
                                           target="_blank">{{ item.replace('attachments/', '') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        <button v-if="action.type == 'View'"
                                type="button"
                                class="btn btn-danger"
                                data-bs-dismiss="modal"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmModal"
                                @click="deleteAction(action.id)">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                        <button v-if="!action.processing"
                                class="btn btn-primary"
                                type="submit">
                            <i class="bi bi-pencil"></i>
                            {{ action.type == 'Create' ? 'Create Task' : 'Save' }}
                        </button>
                        <button v-else
                                class="btn btn-primary"
                                type="submit"
                                disabled>
                            <span class="spinner-border spinner-border-sm"
                                  role="status"
                                  aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Task Modal-->

    <!-- Confirmation Modal -->
    <div class="modal fade"
         id="confirmModal"
         tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-trash"></i>
                        Delete Confirmation
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to permanently remove this task?
                </div>
                <div class="modal-footer">
                    <!-- When I click the Cancel button, the confirmation modal will be hidden. -->
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    <button @click="deleteTask"
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Confirmation Modal-->
</template>

<script setup>

import TopNav from './Includes/TopNav.vue'
import SideNav from './Includes/SideNav.vue'
import FooterNav from './Includes/FooterNav.vue'

import useTasks from '../../composables/tasks'
import Vue3TagsInput from 'vue3-tags-input'
import Datepicker from 'vue3-datepicker'
import { useToast } from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

import { ref, reactive, onMounted, defineComponent } from 'vue'

const toast = useToast()
const { task, tasks, createdTask, getTasksArchives, selectTask, storeTask, updateTask, destroyTask, storeTaskAttachment, storeTaskTags, restoreTask } = useTasks()

defineComponent({
    components: {
        Vue3TagsInput,
        Datepicker
    }
})

onMounted(getTasksArchives)

const initForm = () => ({
    id: '',
    title: '',
    description: '',
    date_picker: null,
    due_date: '',
    priority: '',
    created_at: '',
    updated_at: '',
    user_id: '',
    date_completed: '',
    date_archived: '',
    tags: [],
    attachments: []
})
const initAction = () => ({
    id: '',
    type: '',
    processing: false,
    errors: []
})
const initFilterSort = () => ({
    column: 'id',
    order: 'asc',
    keyword: '',
    priority: '',
    due_date: '',
    due_date_start: '',
    due_date_end: '',
    date_completed: '',
    date_completed_start: '',
    date_completed_end: '',
    date_archived: '',
    date_archived_start: '',
    date_archived_end: '',
    completed: false,
    archived: false
})
const taskTags = ref([])
const taskAttachments = ref(null)

const form = reactive(initForm())
const action = reactive(initAction())
const filterSort = reactive(initFilterSort())

// Reset Action & Form
const resetForm = () => Object.assign(form, initForm());
const resetAction = () => Object.assign(action, initAction());
const resetFilterSort = () => Object.assign(filterSort, initFilterSort());

// View Task
const viewAction = async (id) => {
    // When I click a task, I want to see a modal or a new page that displays the task details
    resetAction()
    resetForm()
    action.id = id
    action.type = "View"
    await viewTask()
}

const viewTask = async () => {
    try {
        // When I click a task, I want to see a modal or a new page that displays the task details
        await selectTask(action.id)
        form.id = task.value.task.id
        form.title = task.value.task.title
        form.description = task.value.task.description
        if (task.value.task.due_date != null) {
            form.date_picker = new Date(task.value.task.due_date)
            form.due_date = task.value.task.due_date
        }
        form.priority = task.value.task.priority
        for (let i = 0; i < task.value.tags.length; i++) {
            form.tags.push(task.value.tags[i].tag)
        }
        for (let i = 0; i < task.value.attachments.length; i++) {
            form.attachments.push(task.value.attachments[i].attachment_path)
        }
    } catch (e) {
        if (e.response.status >= 400) {
            toast.error('An error occur during viewing.', { position: 'top-right', duration: 5000 })
        }
    }
}

// Add Tags
const handleTags = async (tags) => {
    form.tags = tags
}

// Upload Attachments
const handleAttachments = async () => {
    form.attachments = taskAttachments.value?.files
}

const saveTask = async () => {
    action.processing = true
    if (form.date_picker != null)
        form.due_date = form.date_picker.toLocaleDateString('pt-br').split('/').reverse().join('-')
    try {
        if (action.type == 'Create') {
            // When saving a task with valid inputs, I want to see a success message.
            await storeTask(form)
            await storeTaskTags(createdTask.value.id, form.tags)
            await storeTaskAttachment(createdTask.value.id, form.attachments)
            toast.success('Successfully added a task!', { position: 'top-right', duration: 5000 })
        }
        else {
            // When saving a task with valid inputs, I want to see a success message.
            await updateTask(action.id, form)
            await storeTaskTags(action.id, form.tags)
            if (typeof form.attachments[0] !== 'string')
                await storeTaskAttachment(action.id, form.attachments)
            toast.success('Successfully updated a task!', { position: 'top-right', duration: 5000 })
        }
        taskAttachments.value.value = ''
        document.querySelector('#taskModal button[class="btn btn-secondary"]').click()
        await getTasksArchives(filterSort)
    } catch (e) {
        // When creating a task with an invalid inputs, I want to see error message/s below each input field.
        if (e.response.status === 422) {
            if (e.response.config.url.includes('attachments') || e.response.config.url.includes('tags')) {
                action.errors = e.response.data
                if (action.type == 'Create')
                    await destroyTask(createdTask.value.id)
            } else {
                action.errors = e.response.data.errors
            }
            toast.error('Please fill in correct information.', { position: 'top-right', duration: 5000 })
        }
        else if (e.response.status >= 500) {
            toast.error('An error occur during the process.', { position: 'top-right', duration: 5000 })
        }
    } finally {
        action.processing = false
    }
}

// Delete Task
const deleteAction = (id) => {
    // When I click the Delete button in a task view I want to see a confirmation modal before proceeding.
    resetAction()
    action.id = id
    action.type = "Delete"
}

const deleteTask = async () => {
    try {
        // When I click the Proceed button, I want to see a success message.
        await destroyTask(action.id)
        await getTasksArchives(filterSort)
        toast.success('Successfully deleted task!', { position: 'top-right', duration: 5000 })
        document.querySelector('#confirmModal button[class="btn btn-secondary"]').click()
    } catch (e) {
        // If an error occurs, an error message must be displayed.
        if (e.response.status >= 400) {
            toast.error('An error occur during deletion. Must delete task attachments and tags before deleting.', { position: 'top-right', duration: 5000 })
        }
    }
}

const setTaskRestore = async (id) => {
    try {
        // The task should be in the list of unarchived tasks.
        await restoreTask(id)
        await getTasksArchives(filterSort)
        toast.success('Successfully restored task!', { position: 'top-right', duration: 5000 })
    } catch (e) {
        // If an error occurs, an error message must be displayed.
        if (e.response.status >= 400) {
            toast.error('An error occur during the process.', { position: 'top-right', duration: 5000 })
        }
    }
}

</script>
    
<style scoped>
.with-pointer {
    cursor: pointer;
}
</style>