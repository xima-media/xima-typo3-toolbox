document.addEventListener('DOMContentLoaded', function() {
  const getContentElements = async () => {
    const url = encodeURIComponent(window.location.href);
    const endpoint = `/typo3/editable-content-elements?pid=${pid}&returnUrl=${url}`;

    try {
      const response = await fetch(endpoint, { cache: 'no-cache' });
      if (!response.ok) return;

      const jsonResponse = await response.json();

      for (let uid in jsonResponse) {
        const contentElement = jsonResponse[uid];
        const element = document.querySelector(`#c${uid}`);
        if (!element) continue;

        element.classList.add('xima-typo3-toolbox--edit-container');

        const editButton = document.createElement('button');
        editButton.className = 'xima-typo3-toolbox--edit-button';
        editButton.title = contentElement.label;
        editButton.innerHTML = contentElement.icon;

        const dropdownMenu = document.createElement('div');
        dropdownMenu.className = 'xima-typo3-toolbox--dropdown-menu';

        for (let actionName in contentElement.actions) {
          const action = contentElement.actions[actionName];
          let actionElement;

          if (action.type === 'link') {
            actionElement = document.createElement('a');
            actionElement.href = action.url;
          } else if (action.type === 'divider') {
            actionElement = document.createElement('div');
            actionElement.className = 'xima-typo3-toolbox--divider';
          } else {
            actionElement = document.createElement('div');
          }

          actionElement.innerHTML = `${action.icon ?? ''} <span>${action.label}</span>`;
          dropdownMenu.appendChild(actionElement);
        }

        editButton.addEventListener('click', function(event) {
          event.preventDefault();
          dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        element.appendChild(editButton);
        element.appendChild(dropdownMenu);

        document.addEventListener('click', function(event) {
          document.querySelectorAll('.xima-typo3-toolbox--dropdown-menu').forEach(function(menu) {
            const button = menu.previousElementSibling;
            if (!menu.contains(event.target) && !button.contains(event.target)) {
              menu.style.display = 'none';
            }
          });
        });
      }
    } catch (error) {
      console.log(error);
    }
  };

  getContentElements();
});
