// Add event listener to "See More" link
// Add event listener to "See More" link
const seeMoreLinks = document.querySelectorAll('.read-more-btn');

seeMoreLinks.forEach(link => {
  link.addEventListener('click', function(event) {
    event.preventDefault();
    const bookCard = this.closest('.book-card');
    const description = bookCard.querySelector('.book-description');
    const readReviewLink = bookCard.querySelector('.read-review');

    // Toggle the visibility of the book description
    if (description.style.maxHeight) {
      description.style.maxHeight = null;
      this.textContent = '...See More';
    //   readReviewLink.style.display = 'inline-block';
    } else {
      description.style.maxHeight = description.scrollHeight + 'px';
      this.textContent = '...See Less';
    //   readReviewLink.style.display = 'none';
    }
  });
});

//Rating Function
const stars = document.querySelectorAll('.star');
let rating = 0;

stars.forEach((star, index) => {
  star.addEventListener('click', () => {
    let book_id = $(this).parent().attr('id');
    rating = index + 1;
    highlightStars(rating);
    $.ajax({
      method:'post',
      url:'rating.php',
      data:{rating:rating,book_id:book_id},
      success:function(response){
        console.log(response)
      }
    })
  });

  star.addEventListener('mouseover', () => {
    highlightStars(index + 1);
  });

  star.addEventListener('mouseout', () => {
    highlightStars(rating);
  });
});

function highlightStars(num) {
  stars.forEach((star, index) => {
    if (index < num) {
      star.style.backgroundImage = 'url(star-icon-filled.png)';
    } else {
      star.style.backgroundImage = 'url(star-icon.png)';
    }
  });
}

//Book marked function

// Get the bookmark icon element
const bookmarkIcon = document.querySelector('.bookmark-icon');

// Add click event listener to toggle bookmark status
bookmarkIcon.addEventListener('click', function() {
  // Toggle the 'active' class on the bookmark icon
  this.classList.toggle('active');

  // Get the bookmark status
  const isBookmarked = this.classList.contains('active');

  // Update the bookmark status based on the current state
  if (isBookmarked) {
    // Book is bookmarked, change the icon to indicate bookmarked state
    this.querySelector('i').classList.remove('fa-regular');
    this.querySelector('i').classList.add('fa-solid');
    console.log('Bookmarked');
  } else {
    // Book is unbookmarked, change the icon to indicate unbookmarked state
    this.querySelector('i').classList.remove('fa-solid');
    this.querySelector('i').classList.add('fa-regular');
    console.log('Unbookmarked');
  }
});

//Comment Load More Function
$(document).ready(function() {
  var commentsPerPage = 2; // Number of comments to show per page
  var $commentList = $('.comment-list');
  var $loadMoreBtn = $('.load-more-btn');
  var totalComments = $commentList.children('.comment').length;
  var visibleComments = commentsPerPage;
  
  // Initially hide all comments beyond the specified limit
  $commentList.children('.comment:gt(' + (visibleComments - 1) + ')').hide();
  
  // Show/hide "Load More" button based on the number of comments
  if (totalComments <= visibleComments) {
    $loadMoreBtn.hide();
  }
  
  // Handle "Load More" button click event
  $loadMoreBtn.on('click', function() {
    visibleComments += commentsPerPage;
    
    // Show the next set of comments
    $commentList.children('.comment:lt(' + visibleComments + ')').show();
    
    // Hide the "Load More" button if all comments are visible
    if (visibleComments >= totalComments) {
      $loadMoreBtn.hide();
    }
  });
});