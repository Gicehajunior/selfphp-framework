class init_auth {
    
}

/*******
 * Calling out the methods of the init class
 * Happens after the page is done loading.
 */
document.addEventListener("DOMCOntentLoaded", () => {
  const auth = new init_auth();
});
