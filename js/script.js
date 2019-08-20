let i = 0;

let bookForm = document.querySelector('#bookForm');

bookForm.style.display = "none";

addBook = document.querySelector('#addBook');

addBook.addEventListener('click',  function() {
	if (i % 2 == 0){
		bookForm.style.display = "block";
	} else {
		bookForm.style.display = "none";
	}
	i++;
});
