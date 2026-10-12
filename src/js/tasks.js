(() => {
  getTasks();
  let tasks = [];
  let filtered = [];
  const addTaskButton = document.querySelector('#add-task');
  addTaskButton.addEventListener('click', () => showForm());

  async function getTasks() {
    try {
      const projectUrl = getProjectUrl();
      const url = `/api/tasks?url=${projectUrl}`;
      const response = await fetch(url);
      const data = await response.json();
      tasks = data.tasks;
      showTasks();
    } catch (error) {
      console.error(error);
    }
  }

  const filters = document.querySelectorAll('#filters input[type="radio"]');
  filters.forEach(filter => {
    filter.addEventListener('input', filterTasks);
  });

  function filterTasks(e) {
    const filter = e.target.value;
    if (filter !== '') {
      filtered = tasks.filter(task => task.status === Number(filter));
    } else {
      filtered = [];
    }

    showTasks();
  }

  function showTasks() {
    cleanTasks();
    totalPending();
    totalCompleted();
    const taskArray = filtered.length ? filtered : tasks;
    const taskList = document.querySelector('#task-list');
    if (taskArray.length === 0) {
      const textNoTasks = document.createElement('LI');
      textNoTasks.textContent = 'No hay tareas';
      textNoTasks.classList.add('no-tasks');

      taskList.appendChild(textNoTasks);
      return;
    }

    const statusList = {
      0: 'Pendiente',
      1: 'Finalizada'
    };

    taskArray.forEach(task => {
      const taskContainer = document.createElement('LI');
      taskContainer.dataset.taskId = task.id;
      taskContainer.classList.add('task');

      const taskName = document.createElement('P');
      taskName.textContent = task.name;

      const optionsDiv = document.createElement('DIV');
      optionsDiv.classList.add('options');
      taskName.ondblclick = () => {
        showForm(true, { ...task });
      };

      const taskStatusBTN = document.createElement('BUTTON');
      taskStatusBTN.classList.add('task-status');
      taskStatusBTN.classList.add(task.status ? 'finished' : 'pending');
      taskStatusBTN.dataset.taskStatus = task.status;
      taskStatusBTN.textContent = statusList[task.status];
      taskStatusBTN.ondblclick = () => {
        changeTaskStatus({ ...task });
      };

      const deleteTaskBTN = document.createElement('BUTTON');
      deleteTaskBTN.classList.add('delete-task');
      deleteTaskBTN.dataset.taskId = task.id;
      deleteTaskBTN.textContent = 'Eliminar';
      deleteTaskBTN.ondblclick = () => {
        confirmDeleteTask({ ...task });
      };

      optionsDiv.appendChild(taskStatusBTN);
      optionsDiv.appendChild(deleteTaskBTN);

      taskContainer.appendChild(taskName);
      taskContainer.appendChild(optionsDiv);

      taskList.appendChild(taskContainer);
    });
  }

  function changeTaskStatus(task) {
    const newStatus = task.status === 1 ? 0 : 1;
    task.status = newStatus;
    updateTask(task);
  }

  async function updateTask(task) {
    const { id, name, status } = task;

    const data = new FormData();
    data.append('name', name);
    data.append('status', status);
    data.append('projectUrl', getProjectUrl());
    data.append('id', id);

    try {
      const url = '/api/task/update';
      const response = await fetch(url, {
        method: 'POST',
        body: data
      });
      const result = await response.json();
      Swal.fire(result.response.message, result.response.message, result.response.type);
      if (result.response.type === 'success') {
        tasks = tasks.map(task => {
          if (task.id === result.response.id) {
            task.name = name;
            task.status = status;
          }
          return task;
        });
        const modal = document.querySelector('.modal');
        if (modal) modal.remove();
        showTasks();
      }
    } catch (error) {
      console.error(error);
    }
  }

  function confirmDeleteTask(task) {
    Swal.fire({
      title: '¿Estás seguro de querer eliminar esta tarea?',
      showCancelButton: true,
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then(result => {
      if (result.isConfirmed) {
        deleteTask(task);
      }
    });
  }

  async function deleteTask(task) {
    const { id } = task;
    const data = new FormData();
    data.append('id', id);
    data.append('projectUrl', getProjectUrl());

    try {
      const url = '/api/task/delete';
      const response = await fetch(url, {
        method: 'POST',
        body: data
      });
      const result = await response.json();
      // showAlert(result.response.message, result.response.type, document.querySelector('.container-new-task'));
      Swal.fire('Eliminado!', result.response.message, result.response.type);
      if (result.response.type === 'success') {
        tasks = tasks.filter(task => task.id !== id);
        showTasks();
      }
    }
    catch (error) {
      console.error(error);
    }
  }

  function totalPending() {
    const totalPending = tasks.filter(task => task.status === 0);
    const pendingRadio = document.querySelector('#pending');

    if (totalPending.length === 0) {
      pendingRadio.disabled = true;
    } else {
      pendingRadio.disabled = false;
    }
  }

  function totalCompleted() {
    const totalCompleted = tasks.filter(task => task.status === 1);
    const completedRadio = document.querySelector('#completed');

    if (totalCompleted.length === 0) {
      completedRadio.disabled = true;
    } else {
      completedRadio.disabled = false;
    }
  }

  function showForm(edit = false, task = null) {
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
      <form class="form new-task">
        <legend>${edit ? 'Editar tarea' : 'Agrega una nueva tarea'}</legend>
        <div class="field">
          <label for="task">Tarea</label>
          <input type="text" name="task" id="task" placeholder="Nombre Tarea" value="${edit ? task.name : ''}">
        </div>
        <div class="options">
          <input type="submit" class="submit-new-task" value="Guardar">
          <button type="button" class="close-modal">Cancelar</button>
        </div>
      </form>
    `;
    setTimeout(() => {
      const form = document.querySelector('.form');
      form.classList.add('animate');
    }, 0);

    modal.addEventListener('click', (e) => {
      e.preventDefault();
      if (e.target.classList.contains('close-modal') || e.target.classList.contains('modal')) {
        const form = document.querySelector('.form');
        form.classList.add('close');
        setTimeout(() => {
          modal.remove();
        }, 500);
      }

      if (e.target.classList.contains('submit-new-task')) {
        const name = document.querySelector('#task').value.trim();

        if (name === '') {
          const legend = document.querySelector('.form legend');
          showAlert('El nombre de la tarea es obligatorio', 'error', legend);
          return;
        }

        if (edit) {
          task.name = name;
          updateTask(task);
        } else {
          saveTask(name);
        }
      }
    });

    document.querySelector('.dashboard').appendChild(modal);
  }

  function showAlert(msg, type, reference) {
    const previousAlert = document.querySelector('.alert');
    if (previousAlert) previousAlert.remove();
    const alert = document.createElement('DIV');
    alert.classList.add('alert', type, 'margin-top-1rem');
    alert.textContent = msg;

    reference.parentElement.insertBefore(alert, reference.nextElementSibling);

    setTimeout(() => {
      alert.remove();
    }, 5000);
  }

  async function saveTask(task) {
    const data = new FormData();
    data.append('name', task);
    data.append('projectUrl', getProjectUrl());
    const legend = document.querySelector('.form legend');

    try {
      const url = 'http://localhost:3000/api/task';
      const response = await fetch(url, {
        method: 'POST',
        body: data
      });

      const result = await response.json();
      showAlert(result.message, result.type, legend)

      if (result.type === 'success') {
        const modal = document.querySelector('.modal');
        setTimeout(() => {
          modal.remove();
          const taskObj = {
            id: result.id,
            name: task,
            status: 0,
            project_id: result.projectId
          };

          tasks = [...tasks, taskObj];
          showTasks();
        }, 2000);

      }
    } catch (error) {
      console.error(error);
      showAlert('No se pudo crear la tarea, intente denuevo mas tarde', 'error', legend);
    }
  }

  function getProjectUrl() {
    const projectParams = new URLSearchParams(window.location.search);
    const project = Object.fromEntries(projectParams.entries());
    return project.url;
  }

  function cleanTasks() {
    const tasksList = document.querySelector('#task-list')
    while (tasksList.firstChild) {
      tasksList.removeChild(tasksList.firstChild);
    }
  }
})();