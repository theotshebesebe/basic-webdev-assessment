function putTodo(todo) {
  const url = window.location.href + 'api/todo/' + todo.id; // Update the URL based on your endpoint

  fetch(url, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(todo),
  })
    .then(response => {
      if (response.ok) {
        console.log('Todo updated successfully');
        // Handle success, if needed
      } else {
        console.log('Failed to update the todo');
        // Handle error, if needed
      }
    })
    .catch(error => {
      console.log('Error occurred while updating the todo:', error);
      // Handle error, if needed
    });
}

function postTodo(todo) {
  const url = window.location.href + 'api/todo'; // Update the URL based on your endpoint

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(todo),
  })
    .then(response => {
      if (response.ok) {
        console.log('New todo created successfully');
        // Handle success, if needed
      } else {
        console.log('Failed to create the new todo');
        // Handle error, if needed
      }
    })
    .catch(error => {
      console.log('Error occurred while creating the new todo:', error);
      // Handle error, if needed
    });
}

function deleteTodo(todo) {
  const url = `${window.location.href}api/todo/${todo.id}`; // Update the URL based on your endpoint and todo ID

  fetch(url, {
    method: 'DELETE',
  })
    .then(response => {
      if (response.ok) {
        console.log('Todo deleted successfully');
        // Handle success, if needed
      } else {
        console.log('Failed to delete the todo');
        // Handle error, if needed
      }
    })
    .catch(error => {
      console.log('Error occurred while deleting the todo:', error);
      // Handle error, if needed
    });
}

// example using the FETCH API to do a GET request
function getTodos() {
    fetch(window.location.href + 'api/todo')
    .then(response => response.json())
    .then(json => drawTodos(json))
    .catch(error => showToastMessage('Failed to retrieve todos...'));
}

getTodos();
