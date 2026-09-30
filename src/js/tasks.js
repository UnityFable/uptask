(() => {
  getTasks();
  let tasks = [];
  const addTaskButton = document.querySelector('#add-task');
  addTaskButton.addEventListener('click', showForm);

  async function getTasks() {
    try {
      const projectUrl = getProjectUrl();
      const url = `/api/tasks?url=${projectUrl}`;
      const response = await fetch(url);
      const data = await response.json();
      tasks = data.tasks;
      showTasks(tasks);
    } catch (error) {
      console.error(error);
    }
  }

  function showTasks(tasks) {
    cleanTasks();
    const taskList = document.querySelector('#task-list');
    if (tasks.length === 0) {
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

    tasks.forEach(task => {
      const taskContainer = document.createElement('LI');
      taskContainer.dataset.taskId = task.id;
      taskContainer.classList.add('task');

      const taskName = document.createElement('P');
      taskName.textContent = task.name;

      const optionsDiv = document.createElement('DIV');
      optionsDiv.classList.add('options');

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

  function updateTask(task) {
    
  }

  function showForm() {
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
      <form class="form new-task">
        <legend>Agrega una nueva tarea</legend>
        <div class="field">
          <label>Tarea</label>
          <input type="text" name="task" id="task" placeholder="Nombre Tarea">
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
        submitFormNewTask();
      }
    });

    document.querySelector('.dashboard').appendChild(modal);
  }

  function submitFormNewTask() {
    const task = document.querySelector('#task').value.trim();

    if (task === '') {
      const legend = document.querySelector('.form legend');
      showAlert('El nombre de la tarea es obligatorio', 'error', legend);
      return;
    }

    saveTask(task);
  }

  function showAlert(msg, type, reference) {
    const previousAlert = document.querySelector('.alert');
    if (previousAlert) previousAlert.remove();
    const alert = document.createElement('DIV');
    alert.classList.add('alert', type);
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
          showTasks(tasks);
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