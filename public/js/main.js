const articles = document.getElementById('articles');
const id = document.getElementById('deleteButton');


if (articles) {
    articles.addEventListener('click', (e) => {

        if (e.target.id === 'deleteButton') {

            if (confirm('Are you sure')) {
                const idData = e.target.getAttribute('data-id');

                fetch(`/article/delete/${idData}`, {
                        method: 'DELETE'
                    })
                    .then(res => window.location.reload());
            };
        }
    });
}