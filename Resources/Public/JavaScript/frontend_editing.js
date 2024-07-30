document.addEventListener('DOMContentLoaded', function() {
  const elements = document.querySelectorAll('[id^="c"]');

  elements.forEach(function(element) {
    element.classList.add('xima-typo3-toolbox--edit-container');
    const id = element.id.slice(1);
    const url = encodeURIComponent(window.location.href + '#c' + id);

    let editButton = document.createElement('button');
    editButton.className = 'xima-typo3-toolbox--edit-button';
    editButton.title = 'Edit menu';
    editButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="10" xml:space="preserve" viewBox="0 0 16 16"><g fill="currentColor"><path d="m9.293 3.293-8 8A.997.997 0 0 0 1 12v3h3c.265 0 .52-.105.707-.293l8-8-3.414-3.414zM8.999 5l.5.5-5 5-.5-.5 5-5zM4 14H3v-1H2v-1l1-1 2 2-1 1zM13.707 5.707l1.354-1.354a.5.5 0 0 0 0-.707L12.354.939a.5.5 0 0 0-.707 0l-1.354 1.354 3.414 3.414z"/></g></svg>\n';

    let dropdownMenu = document.createElement('div');
    dropdownMenu.className = 'xima-typo3-toolbox--dropdown-menu';

    let editContentElementLink = document.createElement('a');
    editContentElementLink.href = '/typo3/edit-content-element-redirect/' + id + '?returnUrl=' + url;
    editContentElementLink.innerHTML = '<svg width="15" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 16 16"><path fill="#FFF" d="M1 1h14v14H1V1z"/><path fill="#999" d="M1 1v14h14V1H1zm1 1h12v12H2V2z"/><path fill="#666" d="M3 3h10v1H3V3z"/><path fill="#B9B9B9" d="M3 5h10v1H3V5z"/><path fill="#59F" d="M7 7h6v6H7V7z"/><path fill="#FFF" d="M11 12H8l.75-1 .75-1 .75 1 .75 1z"/><path fill="#FFF" d="M12 12H9.333l.667-.667.667-.666.666.666L12 12z"/><circle cx="11.5" cy="9.5" r=".5" fill="#FFF"/><path fill="#B9B9B9" d="M3 7h3v1H3V7zm0 2h3v1H3V9zm0 2h3v1H3v-1z"/></svg> Edit content element';

    let editPageLink = document.createElement('a');
    editPageLink.href = '/typo3/edit-page-redirect/' + id + '?returnUrl=' + url;
    editPageLink.innerHTML = '<svg width="15" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 16 16"><path fill="#EFEFEF" d="M2 0v16h12V4l-4-4H2z"/><path fill="#FFF" d="M10 3.98V0l4 4-4-.02z" opacity=".65"/><path fill="#212121" d="M13 5v5L9 5h4z" opacity=".2"/><path fill="#999" d="M2 0v16h12V4h-.012l.004-.008L10.008.006 10 .014V0H2zm1 1h6v4h4v10H3V1zm7 .412L12.586 4H10V1.412z"/></svg> Edit page';

    dropdownMenu.appendChild(editContentElementLink);
    dropdownMenu.appendChild(editPageLink);

    editButton.addEventListener('click', function(event) {
      event.preventDefault();
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    element.appendChild(editButton);
    element.appendChild(dropdownMenu);
  });

  document.addEventListener('click', function(event) {
    document.querySelectorAll('.xima-typo3-toolbox--dropdown-menu').forEach(function(dropdownMenu) {
      dropdownMenu.parentNode.contains(event.target) ? dropdownMenu.style.display = 'block' : dropdownMenu.style.display = 'none';
    });
  });
});
