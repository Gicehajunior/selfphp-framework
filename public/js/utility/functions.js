// ________________________________________V1____________________________
_tableFilters = {}; 
var paymentInitialized = false;
var phpDateFormat = $('meta[date-format]').attr('date-format');

// Alert User On post requests success.
alertUserOnPostSuccess();
__setFilesUploadArea();
__prohibit_inspect('.app-brand');
__prohibit_inspect('.our-team-card'); 
counterResubmissionRequest();
btnNotWorkingNotification();  

function onParseActionModal(event, action, method='GET', callbackFuncs = undefined, modalAttributeSelector='target-modal') {
    $.ajax({
        type: `${method}`,
        url: `${action}`,
        dataType: 'json',
        success: function (response) {
            event.target.disabled = false;
            if (response) {
                if (response.status && response.status == 'error') {
                    toast(response.status, 500, response.message);
                    return;
                }

                let target_modal = event.target.getAttribute(modalAttributeSelector); 
                if (target_modal) { 
                    __append_html(response.modal, document.querySelector(target_modal));
                    __show_modal(target_modal);
                    __init_close_modal(target_modal);
                }

                setTimeout(() => {
                    dateRangeInitializer();
                    __searchSelectInitializer();
                    if (callbackFuncs !== undefined) { 
                        if (Array.isArray(callbackFuncs)) {
                            callbackFuncs.forEach(item => { 
                                if (typeof item === 'function' && item.callback) {
                                    item(...(item.params?.length ? item.params : [])); // Call directly if it's a function
                                }
                                else if (typeof item === 'object' && item.callback) {
                                    item.callback(...(item.params?.length ? item.params : []));
                                }
                            });
                        }
                    }
                }, 1000);
            } else {
                toast('error', 5000, 'Server error, Please try again or contact the administrator!');
            }
        },
        error: (error) => {
            console.log(error);
            event.target.disabled = false;
            toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
        }
    })
}

function detectMouseInactivity(callback, timeout = 10000) {
    let timer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            callback();
            document.removeEventListener("mousemove", resetTimer);
            document.removeEventListener("keydown", resetTimer);
        }, timeout);
    }

    document.addEventListener("mousemove", resetTimer);
    document.addEventListener("keydown", resetTimer);

    resetTimer(); // Start the timer initially
    resetTimer(); // Start the timer initially
}

function counterResubmissionRequest() {
    const  auth_btns = document.querySelectorAll('.auth-btn');
    
    auth_btns.forEach(auth_btn => {
        if (documentContains(auth_btn)) {
            auth_btn.addEventListener('click', event => { 
                event.preventDefault();
                event.currentTarget.disabled = true;
                const form = event.target.closest('form');
                const orign_textContent = event.target.innerText;
                __append_html('Please wait...', event.target);
                if (form) { 
                    if (form.checkValidity()) {
                        form.submit();
                    } else {
                        event.currentTarget.disabled = false;
                        form.reportValidity(); 
                        __append_html(orign_textContent, event.target);
                        toast('error', 5000, "Please fill out the required fields!");  
                    }
                } else { 
                    event.currentTarget.disabled = false; 
                    __append_html(orign_textContent, event.target);
                    toast('error', 5000, "An error occurred. Please retry again later!");  
                }
            });
        } 
    });
}

function convertPhpDateFormatToJs(phpDateFormat, parseTimeFormat = true) {
    // Create a mapping of PHP format characters to JavaScript format characters
    const formatMapping = {
        'Y': 'yyyy', // Full numeric representation of a year, 4 digits
        'y': 'yy',   // Two-digit representation of a year
        'm': 'mm',   // Numeric representation of a month, with leading zeros
        'n': 'm',    // Numeric representation of a month, without leading zeros
        'd': 'dd',   // Day of the month, 2 digits with leading zeros
        'j': 'd',    // Day of the month without leading zeros
        'H': 'HH',   // 24-hour format of an hour with leading zeros
        'h': 'hh',   // 12-hour format of an hour with leading zeros
        'i': 'mm',   // Minutes with leading zeros
        's': 'ss',   // Seconds with leading zeros
        'A': 'A',    // Uppercase Ante meridiem and Post meridiem
        'a': 'a',    // Lowercase ante meridiem and post meridiem
        'O': 'ZZ',   // Difference to Greenwich time (GMT) in hours
        'e': 'Z',    // Timezone identifier
        'F': 'MMMM', // Full textual representation of a month
        'M': 'MMM',  // A short textual representation of a month
        'D': 'ddd',  // A textual representation of a day, three letters
        'l': 'dddd'  // A full textual representation of the day of the week
    };

    phpDateFormat = phpDateFormat ? phpDateFormat : "d-m-Y";
    
    // Create a regex for the PHP date format keys, ensuring we match only exact keys
    const regex = new RegExp(Object.keys(formatMapping).join('|'), 'g');

    if (!parseTimeFormat) {
        phpDateFormat = phpDateFormat.replace(/H|h|I|i|S|s|:/g, '').trim();
    }

    // Replace the PHP format with JavaScript format using the mapping
    return phpDateFormat.replace(regex, (matched) => formatMapping[matched]);  
}

function todaysDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const formattedDate = `${year}/${month}/${day}`;

    return formattedDate;
}

function getFirstDayOfMonth() {
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1); 
    const offset = firstDay.getTimezoneOffset(); // Adjust for local time zone to avoid potential issues with UTC
    const localFirstDay = new Date(firstDay.getTime() - (offset * 60 * 1000));
    return localFirstDay.toISOString().slice(0, 10);
}

function getLastDayOfMonth() {
    const today = new Date();
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    return lastDay.toISOString().slice(0, 10);
}

function dateRangeInitializer(selectedDatesParams = undefined) {
    try {
        const dateRangeInputFields = document.querySelectorAll('.dateRange')
        var jsDateFormat = convertPhpDateFormatToJs(phpDateFormat, false);
        dateRangeInputFields.forEach(dateRangeInputField => {
            $(dateRangeInputField).datepicker({
                format: jsDateFormat,
                autoclose: false,
                todayHighlight: false,
                multidate: true,
                multidateSeparator: ' - '
            }).on('changeDate', function (e) {
                var selectedDates = $(this).datepicker('getDates');
                if (selectedDates.length > 2) {
                    selectedDates.pop();
                    $(this).datepicker('setDates', selectedDates);
                }
            });

            // Get today's date
            var today = new Date();

            if (selectedDatesParams == undefined) {
                // Get the start of the current month
                var startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                // Get the end of the current month
                var endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            }

            if (selectedDatesParams !== undefined) { 
                var date_range = parseDateRange(selectedDatesParams); 
                var startOfMonth = date_range['startDate'];
                var endOfMonth = date_range['endDate'];
            }

            // Set the date range to cover the entire current month
            $(dateRangeInputField).datepicker('setDates', [startOfMonth, endOfMonth]);
            const daterangefilter = document.querySelectorAll('.daterangefilter');
            daterangefilter.forEach(input => {
                __append_html($('.account_book_created_at').val(), input);
            });
        });
    } catch (error) {
        // catch error
        console.log("NET Error.")
    }
}

function monthYearDateRangeFormatter(payroll_date) {
    if ($(payroll_date).val() === '') { 
        $(payroll_date).val(new Date().toLocaleDateString('en-GB').replace(/\//g, '/'));
    }
    
    if (!$(payroll_date).data('datepicker')) {
        $(payroll_date).datepicker({
            format: "mm/yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
        });
    }

    // Trigger the datepicker to show immediately
    $(payroll_date).datepicker('show');
}

function getMonthsBetween(startDateStr, endDateStr) {
    // Convert date strings to Date objects
    var startDate = new Date(startDateStr);
    var endDate = new Date(endDateStr);
    
    // Calculate the year and month difference
    var months = (endDate.getFullYear() - startDate.getFullYear()) * 12;
    months -= startDate.getMonth();
    months += endDate.getMonth();
    
    // Add one month if endDate's day is greater than startDate's day
    if (endDate.getDate() >= startDate.getDate()) {
        months += 1;
    }
    
    return months;
}

function parseDateRange(dateRangeStr) {
    // Split the date range into start and end dates
    var dates = dateRangeStr.split(' - ');
    
    return {
        startDate: dates[0].trim(),
        endDate: dates[1].trim()
    };
}

function splitDateRange(dateRange) {
    // Split the date range
    let dates = dateRange.split(' - ');

    // Extract start and end dates
    let start_date = dates[0];
    let end_date = dates[1];

    return {
        start_date: start_date,
        end_date: end_date
    };
}

function toast(status, time, message) {
    try {
        if (message != undefined || message != null) {
            toastr.options.newestOnTop = true;
            toastr.options.timeOut = time;
            toastr.options.extendedTimeOut = 0;
            toastr.options.progressBar = true;
            toastr.options.rtl = false;
            toastr.options.closeButton = true;
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 300;
            toastr.options.closeEasing = 'swing';
            toastr.options.preventDuplicates = true;

            if (status == 'success') {
                toastr.success(message);
                playSuccessAudio();
            } else if (status == 'warning') {
                toastr.warning(message);
                playWarningAudio();
            } else if (status == 'info') {
                toastr.info(message);
            } else if (status == 'error') {
                toastr.error(message);
                playErrorAudio();
            }
        }
    } catch (error) {
        console.log('Toast Error: ' + error);
    }
}

// Function to play success audio
function playSuccessAudio() {
    var successAudio = document.getElementById('success-audio');
    if (documentContains(successAudio)) {
        successAudio.play();
    }
}

// Function to play error audio
function playErrorAudio() {
    var errorAudio = document.getElementById('error-audio');
    if (documentContains(errorAudio)) {
        errorAudio.play();
    }
}

// Function to play warning audio
function playWarningAudio() {
    var warningAudio = document.getElementById('warning-audio');
    if (documentContains(warningAudio)) {
        warningAudio.play();
    }
}

function alertUserOnPostSuccess() {
    const toastMessageStatus = document.querySelector('.toast-message-status');
    const toastMessage = document.querySelector('.toast-message');

    if (documentContains(toastMessageStatus) && documentContains(toastMessage)) {
        const status = toastMessageStatus.textContent.toLowerCase().trim();
        const message = toastMessage.textContent.trim();
        toast(status, 5000, message);
    }
}

/**
 * HTML element cloner function. This function prevents 
 * appending multiple listeners and avoiding call conflicts.
 * 
 * @param {HTMLSelectElement} element 
 * @returns {void} void
 */
function cloneNodeElement(element, deep = true, replace = true) {
    var newElement = null;
    if (documentContains(element)) {
        newElement = element.cloneNode(deep);
        if (replace) {
            element.replaceWith(newElement);
        }
    }

    return newElement;
}

function goBack() {
    window.history.back();
}

function __setFilesUploadArea(fpa = "files-upload-area", class_selector = 'SelectDocuments', listing_area = 'SelectDocumentsFileList') {
    const FPAS = document.querySelectorAll(`.${fpa}`);
    FPAS.forEach(FPA => {
        FPA.addEventListener('click', event => {
            // get the nearest file Input
            const fileInput = FPA.parentElement.querySelector(`.${class_selector}`); 
            if (documentContains(fileInput)) {
                __handleFileSelect(FPA, fileInput, listing_area);
                fileInput.click();
            } 
        });
    });
}


function __handleFileSelect(FPA, fileInput, listing_area = 'SelectDocumentsFileList') {
    if (documentContains(fileInput)) { 
        fileInput.addEventListener('change', (event) => {
            const fileList = FPA.parentElement.querySelector(`.${listing_area}`);
            fileList.innerHTML = ''; // Clear previous entries
            const files = event.target.files; 
            
            if (files.length > 0) {
                const parent = fileInput.parentElement;
                const clearButton = parent.querySelector('.clear-file-input-btn');
                if (documentContains(clearButton)) { 
                    clearButton.classList.remove('d-none');
                    clearButton.addEventListener('click', () => {
                        fileInput.value = ''; // Clear the file input
                        __append_html('<li class="m-3">Files cleared!</li>', fileList);
                        clearButton.classList.add('d-none');
                    }, { once: true }); // Avoid duplicate listeners
                }
            }

            for (const file of files) {
                const listItem = document.createElement('li');
                listItem.textContent = `File name: ${file.name}, Size: ${file.size} bytes`;
                fileList.appendChild(listItem); 
            }
        }); 
    }
}

function _setFilesUploadArea(class_selector = 'SelectDocuments', fpa = "files-upload-area", listing_area = 'SelectDocumentsFileList') {
    const fileInput = document.querySelector(`.${class_selector}`);
    const FPA = document.querySelector(`.${fpa}`);
    if (documentContains(FPA)) {
        handleFileSelect(class_selector, listing_area);
        fileInput.click();
    }
}

function setFilesUploadArea(class_selector = 'SelectDocuments', fpa = "files-upload-area", listing_area = 'SelectDocumentsFileList') {
    const fileInput = document.querySelector(`.${class_selector}`);
    const FPA = document.querySelector(`.${fpa}`);
    if (documentContains(FPA)) {
        handleFileSelect(class_selector, listing_area);
        FPA.addEventListener('click', event => {
            fileInput.click();
        });
    }
}

function handleFileSelect(class_selector, listing_area = 'SelectDocumentsFileList') {
    const fileInput = document.querySelector(`.${class_selector}`);
    const fileList = document.querySelector(`.${listing_area}`);
    
    if (!documentContains(fileInput) || !documentContains(fileList)) {
        console.warn('File input or listing area not found');
        return;
    }

    fileInput.addEventListener('change', (event) => {
        fileList.innerHTML = ''; // Clear previous entries
        const files = event.target.files;

        if (files.length === 0) {
            clearButton.classList.add('d-none');
            fileList.textContent = 'No files selected.';
            return;
        }

        if (files.length > 0) {
            const parent = fileInput.parentElement;
            const clearButton = parent.querySelector('.clear-file-input-btn');
            if (documentContains(clearButton)) { 
                clearButton.classList.remove('d-none');
                clearButton.addEventListener('click', () => {
                    fileInput.value = ''; // Clear the file input 
                    __append_html('<li class="m-3">Files cleared!</li>', fileList);
                    clearButton.classList.add('d-none');
                }, { once: true }); // Avoid duplicate listeners
            }
        }

        for (const file of files) {
            const listItem = document.createElement('li');
            listItem.textContent = `File name: ${file.name}, Size: ${file.size} bytes`;
            fileList.appendChild(listItem); 
        } 

    });
}

function __amount(str) {
    // Remove leading and trailing spaces
    var str = String(str);
    str = str.trim();

    // Check if the string starts with a currency code and remove it if it does
    const regex = /^[A-Z]{3}\s*([0-9,.]+)$/;

    // Test if the string matches the regex
    const match = str.match(regex);
    
    if (match) {
        // Extract the matched number part and remove any commas
        str = match[1].replace(/,/g, '');
    }

    // Replace commas with periods (if needed for your locale)
    str = str.replace(",", "");
    str.trim();

    // Convert the string to a number
    const amount = parseNumberFromCurrency(str);
    
    // Check if the conversion was successful
    if (isNaN(amount)) {
        throw new Error("Invalid amount format");
    }

    return amount;
}

function __formatCurrency(amount, options = {}) {
    const defaultOptions = {
        currency: "USD", // Default currency
        locale: "en-US", // Default locale
        minimumFractionDigits: 2, // Default number of decimal places
        maximumFractionDigits: 2, // Default number of decimal places
        style: "currency", // Default formatting style
    };

    const mergedOptions = {
        ...defaultOptions,
        ...options
    };

    if (typeof amount !== "number" || isNaN(amount)) {
        return "Invalid amount";
    }

    if (!mergedOptions.currency) return;

    try {
        const formatter = new Intl.NumberFormat(mergedOptions.locale, {
            style: mergedOptions.style,
            currency: mergedOptions.currency,
            minimumFractionDigits: mergedOptions.minimumFractionDigits,
            maximumFractionDigits: mergedOptions.maximumFractionDigits,
        });

        return formatter.format(amount);
    } catch (error) {
        console.error("Error formatting currency:", error);
        return null;
    }
}

function formatCurrency(amount, options = {}) {
    const defaultOptions = {
        currency: "USD", // Default currency
        locale: "en-US", // Default locale
        minimumFractionDigits: 2, // Default number of decimal places
        maximumFractionDigits: 2, // Default number of decimal places
        style: "currency", // Default formatting style
    };

    const mergedOptions = {
        ...defaultOptions,
        ...options
    };

    if (typeof amount !== "number" || isNaN(amount)) {
        return "Invalid amount";
    }

    if (!mergedOptions.currency) return;

    try {
        const formatter = new Intl.NumberFormat(mergedOptions.locale, {
            style: mergedOptions.style,
            currency: mergedOptions.currency,
            minimumFractionDigits: mergedOptions.minimumFractionDigits,
            maximumFractionDigits: mergedOptions.maximumFractionDigits,
        });

        let formattedAmount = formatter.format(amount);
        formattedAmount = formattedAmount.toString();
        if (amount < 0) {
            formattedAmount = `${mergedOptions.currency} ${formattedAmount.replace(mergedOptions.currency, '')}`;
        }

        return formattedAmount;
    } catch (error) {
        console.error("Error formatting currency:", error);
        return null;
    }
}

function formatDateToDDMMYY(date) {
    // Ensure the input is a Date object
    if (!(date instanceof Date)) {
        throw new Error('Invalid date');
    }

    // Get day, month, and year components
    let day = date.getDate();
    let month = date.getMonth() + 1; // Months are zero-based
    let year = date.getFullYear() % 100; // Get last two digits of the year

    // Pad single-digit day and month with leading zero
    day = day < 10 ? '0' + day : day;
    month = month < 10 ? '0' + month : month;

    // Concatenate components with '/' separator
    return day + '/' + month + '/' + year;
}

function removeCurrency(value) {
    if (typeof value !== "string") return 0;
    
    let numericValue = value.replace(/[^0-9.]/g, "");
    
    return Math.floor(parseFloat(numericValue) || 0);
}

function disableDtActionBtns (selector) {
    const actionBtns = document.querySelectorAll(selector);
    actionBtns.forEach(actionBtn => {
        actionBtn.disabled = true;
    }); 
}

function enableDtActionBtns (selector) {
    const actionBtns = document.querySelectorAll(selector);
    actionBtns.forEach(actionBtn => {
        if (actionBtn.disabled) {
            actionBtn.disabled = false;
        } 
    }); 
}

function getSelectElementTextContentOnchangeEvent(selectElement) {
    var selectedIndex = selectElement.selectedIndex;
    var selectedOptionText = selectElement.options[selectedIndex].textContent;

    return selectedOptionText
}

function getMultipleSelectedInputValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;

    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];

        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }

    return result;
}

function getSelectedAttributes(class_selector, customAttributes = []) {
    var selectElement = document.querySelector(`.${class_selector}`);
    var selectedOptions = selectElement.selectedOptions;
    var attributesArray = [];

    for (var i = 0; i < selectedOptions.length; i++) {
        var option = selectedOptions[i];
        var attributeObject = {};

        customAttributes.forEach(attribute => {
            var customAttribute = option.getAttribute(attribute);

            attributeObject[attribute] = customAttribute;
        });

        attributesArray.push(attributeObject);
    }

    return attributesArray;
}

function preventMultipleSelections(selectors) {
    const fields = selectors.map(selector => document.querySelector(selector));
    
    fields.forEach(field => {
        // if (documentContains(field)) {
            field.addEventListener('change', function() {
                if (this.value) {
                    fields.forEach(f => {
                        if (f !== this) {
                            if (f.value) {
                                f.value = ""; // Clear the latter field
                            }
                            f.disabled = true;
                        }
                    });
                } else {
                    fields.forEach(f => f.disabled = false);
                }
            });
        // }
    });
}

function reset_form(docClass, formFieldClassSelector, modalClassSelector = null, DomAppendedElements = []) {
    const docs = document.querySelectorAll(`.${docClass}`);

    docs.forEach(doc => {
        if (documentContains(doc)) {
            const form_fields = doc.querySelectorAll(`.${formFieldClassSelector}`);

            form_fields.forEach((field) => {
                if (field.classList.contains('searchSelect')) {
                    $('.searchSelect option:first').prop('selected', true);
                }

                if (field.type == 'checkbox') {
                    field.checked = false;
                }
                else {
                    field.value = '';
                } 
            });

            if (Array.isArray(DomAppendedElements) && DomAppendedElements.length > 0) {
                DomAppendedElements.forEach(element => {
                    if (documentContains(element)) {
                        $(element).empty();
                    }
                });
            }

            const elements = document.querySelectorAll('.SelectDocumentsFileList');

            elements.forEach(element => { 
                if (documentContains(element)) {
                    while (element.firstChild) {
                        element.removeChild(element.firstChild);
                    } 
                }
            });
        }

        if (modalClassSelector !== null) {
            $(`.${modalClassSelector}`).modal("hide");
        }
    });
}


function recursiveClearForm(selector, fileListSelector = null) {
    const formElement = document.querySelector(selector);
    if (!formElement) return;

    function clearElement(element) {
        if (element.tagName === 'INPUT') {
            if (element.type === 'checkbox' || element.type === 'radio') {
                element.checked = false;
            } else if (element.type === 'file') {
                element.value = '';
            } else {
                element.value = '';
            }
        } else if (element.tagName === 'TEXTAREA') {
            element.value = '';
        } else if (element.tagName === 'SELECT') {
            element.selectedIndex = 0;
        } else {
            Array.from(element.children).forEach(clearElement);
        }
    }

    clearElement(formElement);
    
    if (fileListSelector) {
        const fileListContainers = document.querySelectorAll(fileListSelector);
        fileListContainers.forEach(fileListContainer => {
            if (fileListContainer) {
                fileListContainer.innerHTML = '';
            }
        });
    }
}

/**
 * Accepts the modal HTML element selector (class name) and shows the modal.
 * Uses both versions of bootstrap, 4 and 5 if applicable.
 * 
 * @param {string} modal - Class name or selector (e.g. 'myModal' or '.myModal').
 * @returns {void}
 */
function __show_modal(modal) {
    let selector = modal.startsWith('.') ? modal : `.${modal}`;
    let modalElement = document.querySelector(selector); 
    if (!modalElement) {
        console.warn(`Modal not found: ${modal}`);
        return;
    }

    const isBootstrap5 = typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined';

    if (isBootstrap5) {
        let bsModal = bootstrap.Modal.getOrCreateInstance(modalElement);

        if (modalElement.classList.contains('show')) {
            bsModal.hide();
            modalElement.addEventListener('hidden.bs.modal', function handler() {
                modalElement.removeEventListener('hidden.bs.modal', handler);
                bsModal.show();
            });
        } else {
            bsModal.show();
        }
    } else if (typeof $ === 'function' && typeof $(modalElement).modal === 'function') {
        let $modal = $(modalElement);

        if ($modal.hasClass('show')) {
            $modal.modal('hide');
            $modal.on('hidden.bs.modal', function handler() {
                $modal.off('hidden.bs.modal', handler);
                $modal.modal('show');
            });
        } else {
            $modal.modal('show');
        }
    } else {
        console.warn('No supported Bootstrap version detected.');
    }
}

function __close_modal() {
    var modalClosed = false; 
    document.querySelectorAll('.close-modal-btn').forEach(closeModalBtn => {
        if (closeModalBtn.click()) {
            modalClosed = true;
            $(document.body).removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
    });

    return modalClosed;
}

function __quick_close_modal(modalClass) {
    var $modals = modalClass.startsWith('.') ? $(modalClass) : $(`.${modalClass}`);

    if ($modals.length === 0) {
        console.warn(`No modals found with class: ${modalClass}`);
        return;
    }

    $modals.each(function() {
        var $modal = $(this);
        
        $modal.modal('hide');

        $modal.on('hidden.bs.modal', function() {
            if ($("body").hasClass("modal-open")) {
                $("body").removeClass("modal-open");
            }
            $('body').removeAttr('style');
            $modal.off('hidden.bs.modal');
        });
    });
}

function __init_close_modal(selector=undefined) {
    const closing_modal_btns = document.querySelectorAll('.close-modal-btn');
    closing_modal_btns.forEach(closing_modal_btn => {
        closing_modal_btn.addEventListener('click', event => {
            event.preventDefault();  
            // Find the respective modal using the provided selector
            let $modal;
            if (selector === undefined) {
                $modal = $(event.target).closest('.modal');
            } else {
                if (selector.startsWith('.')) {
                    $modal = $(`${selector}`);
                }
                else {
                    $modal = $(`.${selector}`);
                }
            }
            
            if ($modal.length) {
                // Use jQuery to hide the modal
                $modal.modal('hide');
                $(document.body).removeClass('modal-open');
                $('.modal-backdrop').remove();
            } else {
                console.error('Modal not found with the given selector:', selector);
            }
        });
    });
}

function __front_modal(modalSelector) {
    $(`.${modalSelector}`).on('show.bs.modal', function (e) {
        var highestZIndex = 1050; // Start with Bootstrap's default
        $('.modal').each(function () {
            var currentZIndex = parseInt($(this).css('z-index'), 10);
            if (currentZIndex > highestZIndex) {
                highestZIndex = currentZIndex;
            }
        });
        $(this).css('z-index', highestZIndex + 10);
        $('.modal-backdrop').not('.modal-stack').css('z-index', highestZIndex + 9).addClass('modal-stack');
    });
}

function isModalClosed(modal) {
    if (!$(`.${modal}`).is(':visible')) {
        return true;
    }

    return false;
}

function __prohibit_inspect(selector, doc=document) {
    const dom_element = doc.querySelector(selector);
    if (documentContains(dom_element)) {
        dom_element.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        // Disable keyboard shortcuts like Ctrl+S, Ctrl+U, etc.
        dom_element.addEventListener('keydown', function(event) {
            if (event.ctrlKey && (event.key === 's' || event.key === 'u')) {
                event.preventDefault();
            }
        });
    }
}

/**
 * Appends HTML content to an element without replacing existing content.
 * @param {string} content - The HTML content to append.
 * @param {HTMLElement} element - The element to which the content will be appended.
 */
function __append_html(content, element, append=false) {
    if (append) {
        element.innerHTML += content; // Append new content
    } else {
        element.innerHTML = content; // Replace content
    }
}

/**
 * Appends text content to an element without replacing existing content using jQuery.
 * @param {string} content - The text content to append.
 * @param {jQuery} $element - The jQuery element to which the content will be appended.
 */
function __append_html_content(content, element) { 
    element.text(content);
}

function __modal_call(classTag, view) {
    modalContainer = document.querySelector(`.${classTag}`);
    if (documentContains(modalContainer)) {
        modalContainer.innerHTML = view;
        var respectiveModal = modalContainer.firstElementChild;
        if (respectiveModal) {
            const modalId = respectiveModal.id;
            // open the modal
            $(`#${modalId}`).modal('show');
            const multipleselectpickers = respectiveModal.querySelectorAll('#multiple-checkboxes');

            for (let index = 0; index < multipleselectpickers.length; index++) {
                const multipleSelectPicker = multipleselectpickers[index];
                $(multipleSelectPicker).selectpicker();
            }
        }
    } else {
        console.log("ERROR: Modal container not found!");
    }
}

function __initCallBackFuncs(callbackFuncs=[]) {
    callbackFuncs.forEach(callBackFunc => {
        callBackFunc();
    });
}

function exchange_currency_computation(amount, exchange_rates = {}) {
    // console.log(amount);
    // console.log(`From Rate: ${exchange_rates['fromRate']}`);
    // console.log(`To Rate: ${exchange_rates['toRate']}`);
    const conversion = ((parseFloat(amount) * parseFloat(exchange_rates['toRate'])) / parseFloat(exchange_rates['fromRate'])).toFixed(2);
    // console.log(`Conversion: ${conversion}`);
    return conversion;
}

function __num_format(num, min_decimal_places = 2, max_decimal_places = 2) {
    const formattedNumber = num.toLocaleString('en-US', {
        style: 'decimal',
        minimumFractionDigits: min_decimal_places,
        maximumFractionDigits: max_decimal_places,
    });

    return formattedNumber;
}

// Function to calculate VAT
function calculateVAT(amount, vatRate) {
    // Calculate VAT amount
    var vatAmount = amount * (vatRate / 100);

    // Calculate total amount including VAT
    var totalAmount = amount + vatAmount;

    // Return an object with original amount, VAT amount, and total amount
    return {
        originalAmount: amount,
        vatAmount: vatAmount,
        totalAmount: totalAmount
    };
}

/**
 * Checks if the element exists in a specified body/body-element
 * 
 * @returns {Boolean} True|False
 */
function documentContains(target) {
    if (target && document.body.contains(target)) {
        return true;
    }

    return false;
}

// Function to extract file properties
function getFileProperties(file) {
    if (!file) {
        return null;
    }

    return {
        name: file.name,
        size: file.size,
        type: file.type,
        lastModified: file.lastModified,
        lastModifiedDate: file.lastModifiedDate,
        webkitRelativePath: file.webkitRelativePath
        // Add more properties as needed
    };
}

function serializeData(param, __files = [], processing = true) {
    var data = {}

    if (param['form']) {
        var _class = param['class'];
        if (!_class) {
            _class = 'form-control';
        }

        const form_data = param['form'].querySelectorAll(`.${_class}`);

        form_data.forEach(field => {
            if (param['validate'] && param['validate'] == true) {
                if (field.required && field.value.length == 0) {
                    toast('error', 5000, `Madatory fields cannot be null!`)
                    return false;
                } else {
                    if (field.type == 'file') {
                        if (field.files.length > 1 && __files.length > 0) {
                            var _files = [];
                            for (var i = 0; i < field.files.length; i++) {
                                _files.push(field.files[i]);
                            }
                            data[field.id] = _files;
                        } else {
                            if (field.files.length > 0) {
                                data[field.id] = field.files;
                            }
                        }
                    } else if (field.type == 'checkbox') {
                        if (field.checked) {
                            data[field.id] = field.value;
                        }
                    } 
                    else {
                        console.log(field.tagName);
                        if (field.tagName.toLowerCase() == 'select' && field.hasAttribute('multiple')) {
                            data[field.id] = getMultipleSelectedInputValues(field);
                        } else {
                            data[field.id] = field.value;
                        }
                    }
                }
            } else {
                if (field.type == 'file') {
                    if (field.files.length > 1 && __files.length > 0) {
                        var _files = []
                        for (var i = 0; i < field.files.length; i++) {
                            _files.push(field.files[i]);
                        }
                        data[field.id] = _files;
                    } else {
                        if (field.files.length > 0) {
                            data[field.id] = field.files;
                        }
                    }
                } else if (field.type == 'checkbox') {
                    if (field.checked) {
                        data[field.id] = field.value;
                    } 
                } 
                else {
                    if (field.tagName.toLowerCase() == 'select' && field.hasAttribute('multiple')) {
                        data[field.id] = getMultipleSelectedInputValues(field);
                    } else {
                        data[field.id] = field.value;
                    }
                }
            }
        });

        if (param['validate'] && param['validate'] == true) {
            if (param['fieldIds']) {
                param['fieldIds'].forEach(fieldId => {
                    if (data[fieldId] && data[fieldId].length == 0) {
                        toast('error', 5000, `Madatory fields cannot be null!`)
                        return false;
                    }
                });
            }
        }
    }

    if (data.length == 0) {
        toast('error', 5000, `Madatory fields cannot be null!`)
        return false;
    }

    if (processing == false) {
        return data;
    } else {
        const formData = new FormData();

        for (const property in data) {
            if (data.hasOwnProperty(property)) {
                const value = data[property];

                // Check if the property is 'profilePicture' and it's not an empty object
                if (property === 'identity_document' || property === 'profile_picture' || property === 'systemUpdateZipFile') {
                    console.log(value[0]);
                    formData.append(property, value[0], value[0].name);
                } else if (__files.includes(property)) {
                    for (var i = 0; i < value.length; i++) {
                        if (value[i] && value[i].name) {
                            formData.append(property + '[' + i + ']', value[i], value[i].name);
                        }
                    }
                } else {
                    // Append other properties to FormData
                    formData.append(property, value);
                }
            }
        }
        return formData;
    }
}

function mergeMultipleFormData(form_data, __files = []) {
    const formData = new FormData();

    for (const property in form_data) {
        if (form_data.hasOwnProperty(property)) {
            const value = form_data[property];

            // Check if the property is 'profilePicture' and it's not an empty object
            if (property === 'identity_document' && property === 'profile_picture' || property === 'systemUpdateZipFile') {
                formData.append(property, value[0], value[0].name);
            } else if (__files.includes(property)) {
                for (var i = 0; i < value.length; i++) {
                    console.log(value[i])
                    if (value[i] && value[i].name) {
                        formData.append(property + '[' + i + ']', value[i], value[i].name);
                    }
                }
            } else {
                // Append other properties to FormData
                formData.append(property, value);
            }
        }
    }

    return formData;
}

function isFormDataEmpty(formData) {
    for (let pair of formData.entries()) {
        return false;
    }

    return true;
}

function recursiveClassNameRemover(selector_collection, class_name) {
    selector_collection.forEach(selector => {
        selector.classList.remove(class_name);
    });
}

function addClassNameRecursively(selector_collection, class_name) {
    selector_collection.forEach(selector => {
        selector.classList.add(class_name);
    });
}

function debug_form_data(formData) {
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
}

function addOrdinalSuffix(number) {
    if (typeof number !== 'number' || isNaN(number)) {
        return 'Invalid input';
    }

    // Extract the last two digits to determine the ordinal suffix
    const lastTwoDigits = number % 100;

    // Determine the appropriate suffix based on the last two digits
    let suffix;
    if (lastTwoDigits >= 11 && lastTwoDigits <= 13) {
        suffix = 'th';
    } else {
        const lastDigit = number % 10;
        switch (lastDigit) {
            case 1:
                suffix = 'st';
                break;
            case 2:
                suffix = 'nd';
                break;
            case 3:
                suffix = 'rd';
                break;
            default:
                suffix = 'th';
        }
    }

    return number + suffix;
}

function getTableFilterValues() {
    if (!_tableFilters.hasOwnProperty('fromDate') && !_tableFilters.hasOwnProperty('toDate')) {
        _tableFilters['fromDate'] = getFirstDayOfMonth();
        _tableFilters['toDate'] = getLastDayOfMonth();
    }

    return _tableFilters;
}

function refreshTableOnFiltersChangeEvent(tableClass, callbackFunc) {
    $(document).on('change', `.${tableClass}`, function (event) {
        const {
            id,
            value
        } = event.target;

        if (value.length > 0) {
            _tableFilters[id] = value;
        } else {
            delete _tableFilters[id];
        }

        callbackFunc();
    });
}

function quickprintdt(printable_table_section, type = "html", header = null, button = null) {
    const noPrintSelectors = [
        '.dataTables_length',
        '.pagination',
        '.DataTables_Table_0_filter',
        '.dataTables_filter',
        '.dataTables_info',
        '.dataTables_paginate'
    ];

    const masterInstance = new Master();

    // Hide unnecessary UI elements when printing
    noPrintSelectors.forEach(selector => {
        $(selector).addClass("no-print");
    });
    
    const performPrint = () => { 
        masterInstance.showOverlay();

        const table = $(`.${printable_table_section}:not(.d-none)`).DataTable();
        const api = table.api ? table.api() : table; // Support if DataTable instance
        const visibleData = table.rows({ search: 'applied' }).indexes().toArray();

        if (!visibleData.length) {
            setTimeout(() => {
                masterInstance.hideOverlay();
            }, 1000);
            toast('warning', 500, 'No data to print');
            return;
        }

        // Get currency dynamically from the first row
        const rowData = table.row(visibleData[0]).data();
        const currency = rowData?.currency || 'KES';

        const colsToCompute = [];
        table.columns(':visible').every(function(index) {
            const headerEl = this.header(); // DOM <th> element
            const attrValue = headerEl.getAttribute('total_compute'); // returns string or null
        
            if (attrValue && attrValue.toLowerCase() === 'true') {
                colsToCompute.push(index);
            }
        });
        
        // Initialize totals for the specified columns
        const columnTotals = {};
        colsToCompute.forEach(idx => columnTotals[idx] = 0);

        // Start building HTML
        let fullTableHTML = `<table style="width:100%; border-collapse: collapse;">
                                <thead><tr>`;

        // Headers
        table.columns(':visible').every(function(index) {
            const $header = $(this.header());
            if (!$header.hasClass('no-print')) {
                fullTableHTML += `<th style="border:1px solid black; text-align:center;">${$header.text()}</th>`;
            }
        });
        fullTableHTML += `</tr></thead><tbody>`;

        // Rows and totals
        visibleData.forEach(rowIdx => {
            fullTableHTML += '<tr>';
            table.columns(':visible').every(function(colIdx) {
                const $header = $(this.header());
                if (!$header.hasClass('no-print')) {
                    const cellData = table.cell(rowIdx, colIdx).data();
                    fullTableHTML += `<td style="border:1px solid black; text-align:center;">${cellData}</td>`;

                    // Sum only the specified columns
                    if (colsToCompute.includes(colIdx)) {
                        const numericValue = parseFloat(cellData.toString().replace(/[^0-9.-]+/g,""));
                        if (!isNaN(numericValue)) columnTotals[colIdx] += numericValue;
                    }
                }
            });
            fullTableHTML += '</tr>';
        });

        // Append totals row at the end of tbody
        fullTableHTML += '<tr>';
        table.columns(':visible').every(function(colIdx) {
            const $header = $(this.header());
            if (!$header.hasClass('no-print')) {
                if (colsToCompute.includes(colIdx)) {
                    // Format total dynamically using the detected currency
                    const formattedTotal = formatCurrency(columnTotals[colIdx], {
                        currency: currency,
                        maximumFractionDigits: 2
                    });
                    fullTableHTML += `<th style="border:1px solid black; text-align:center;">${formattedTotal}</th>`;
                } else if (colIdx === 0) {
                    fullTableHTML += `<th style="border:1px solid black; text-align:center;">Total</th>`;
                } else {
                    fullTableHTML += `<th style="border:1px solid black; text-align:center;"></th>`;
                }
            }
        });
        fullTableHTML += '</tr>';

        fullTableHTML += '</tbody></table>';
        
        // Target sections
        const printableWrapper = document.getElementById('printable_tb_section');
        const headerSection = printableWrapper.querySelector('.header-section .dynamic-content');
        const contentSection = printableWrapper.querySelector('.content-print-section');

        // clear previous print content
        headerSection.querySelectorAll('.dynamic-header').forEach(el => el.remove());
        __append_html('', contentSection);

        // Append dynamic header HTML
        __append_html(`<h4 class="dynamic-header">${header ?? ''}</h4>`, headerSection);

        // Append table HTML
        __append_html(fullTableHTML, contentSection);

        // Print entire wrapper (header + content)
        printJS({
            printable: 'printable_tb_section',
            type: type,
            style: `
                .no-print { display: none; }
                button { border: none; padding: 0; margin: 0; font-family: inherit; cursor: pointer; background-color: transparent; }
                table { width:100%; border-collapse: collapse; border: 1px solid #ddd; }
                table td, table th { border: 1px solid black; text-align: center; padding: 8px; }
                table tr { border-bottom: 1px solid black; }
                table th { font-weight: bold; }
            `
        });

        setTimeout(() => {
            masterInstance.hideOverlay();
        }, 1000);
    };

    try {
        if (!button) {
            performPrint();
        } else {
            const eventBtns = document.querySelectorAll(button);
            eventBtns.forEach(eventBtn => {
                if (eventBtn) {
                    eventBtn.addEventListener('click', performPrint);
                } else {
                    console.warn(`Button:"${button}" not found.`);
                }
            });
        }
    } catch (error) {
        console.log(error);
        masterInstance.hideOverlay();
        toast('warning', 500, lang.print_error);
    }
}

function quickprint(printable_section, table=null, type = "html", header = null, button = null) { 
    try {
        const noPrintSelectors = [
            '.dataTables_length',
            '.pagination',
            '.DataTables_Table_0_filter',
            '.dataTables_filter',
            '.dataTables_info',
            '.dataTables_paginate'
        ];
    
        noPrintSelectors.forEach(selector => {
            $(selector).addClass("no-print");
        });
    
        if (button == null) {
            printJS({
                printable: printable_section,
                type: type,
                header: header,
                style: '.no-print { display: none; } button {border: none; padding: 0; margin: 0; font-family: inherit; cursor: pointer; background-color: transparent;} table {width:100%; border-collapse: collapse; border: 1px solid #ddd;} table td, table th {border: 1px solid black; border-right: 1px solid black;text-align: center;} table tr {border-bottom: 1px solid black;text-align: center;} table th {padding: 8px; text-align: center;}'
            });
        } else {
            const eventBtn = document.getElementById(`${button}`);

            eventBtn.addEventListener('click', event => {
                printJS({
                    printable: printable_section,
                    type: type,
                    header: header,
                    style: '.no-print { display: none; } button {border: none; padding: 0; margin: 0; font-family: inherit; cursor: pointer; background-color: transparent;} table {width:100%; border-collapse: collapse; border: 1px solid #ddd;} table td, table th {border: 1px solid black; border-right: 1px solid black;text-align: center;} table tr {border-bottom: 1px solid black;text-align: center;} table th {padding: 8px; text-align: center;}'
                });
            });

        }
    } catch (error) {
        toast('warning', 500, lang.print_error);
    }
}

function addNewPaymentAccount(btn, type) { 
    const $form      = $(btn).closest('form, .payment-account-details');
    const $container = $form.find(`.${type}`);

    if (!$container.length) {
        console.error('Container not found for type:', type);
        return;
    }

    // Determine correct block selector
    const blockSelector =
        type === 'bank-accounts'
            ? '.bank-account-details'
            : '.mobile-money-container';

    // Correct index (count existing blocks in THIS form)
    const index = $container.find(blockSelector).length;

    // Clone the first real block (not wrapper / whitespace)
    const template = $container.find(blockSelector).first();
    const clonedSection = template.clone(false, false);

    /* -----------------------------
     | CLEANUP
     |------------------------------*/
    clonedSection.find('.select2-container').remove();
    clonedSection.find('.searchSelect')
        .removeClass('select2-hidden-accessible')
        .removeAttr('data-select2-id');

    clonedSection.find('input, textarea').val('');
    clonedSection.find('select').prop('selectedIndex', 0);

    /* -----------------------------
     | ID + NAME MAPPING
     |------------------------------*/
    clonedSection.find('[id]').each(function () {
        const $el   = $(this);
        const oldId = $el.attr('id');
        const newId = `${oldId}_${Date.now()}`;

        $el.attr('id', newId);

        if (type === 'bank-accounts') {
            if (oldId === 'accountHolder') {
                $el.attr('name', `bank_accounts[${index}][account_holder_name]`);
            }
            if (oldId === 'accountNumber') {
                $el.attr('name', `bank_accounts[${index}][account_number]`);
            }
            if (oldId === 'bankName') {
                $el.attr('name', `bank_accounts[${index}][bank_name]`);
            }
        }

        if (type === 'mobile-money') {
            if (oldId === 'mobileMoneyProvider') {
                $el.attr('name', `mobile_money_accounts[${index}][mobile_money_provider]`);
            }
            if (oldId === 'mbphoneNumber') {
                $el.attr('name', `mobile_money_accounts[${index}][phone_number]`);
            }
            if (oldId === 'mbaccountHolder') {
                $el.attr('name', `mobile_money_accounts[${index}][account_holder_name]`);
            }
        }

        clonedSection.find(`label[for="${oldId}"]`).attr('for', newId);
    });

    /* -----------------------------
     | CLOSE BUTTON
     |------------------------------*/ 
    var closeIcon = $("<span>")
        .text('X')
        .addClass("close-icon") // Add a class for styling
        .on('click', function () {
            // Remove the parent of the icon (which is the cloned element)
            $(this).parent().remove();
        });

    // Append the delete button to the cloned element
    clonedSection.addClass("cloned-element").append(closeIcon); 

    /* -----------------------------
     | APPEND + REINIT
     |------------------------------*/
    $container.append(clonedSection);

    clonedSection.find('.searchSelect').each(function () {
        const endpoint = $(this).data('endpoint') || '';
        searchSelectUtilFunction($(this), endpoint);
    });
}

function _getPropertyUnits() {
    const unitTargetInputElement = document.querySelector('.unitTargetInputElement');

    $.ajax({
        url: `/lease/users/getRespectivePropertyUnit?id=${unitTargetInputElement.value}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            $.each(response.data, function (index, options) {
                $.each(options, function (index, option) {
                    var item_id_notation = unitTargetInputElement.getAttribute('selector-id');
                    var item_name_notation = unitTargetInputElement.getAttribute('selector-name');
                    var item_unique_notation = unitTargetInputElement.getAttribute('selector-unique');
                    var text_option;
                    if (item_unique_notation.length > 0) {
                        text_option = `${option[item_name_notation]} - ${option[item_unique_notation]}`;
                    } else {
                        text_option = `${option[item_name_notation]}`;
                    }

                    unitTargetInputElement.append($('<option>', {
                        value: `${option[item_id_notation]}`,
                        text: text_option
                    }));
                });
            });
        },
        error: function (error) {
            console.log('Error fetching data: ', error);
        }
    });
}

function clearOptionsFromIndex(selectElement, startIndex) {
    for (let i = selectElement.options.length - 1; i >= startIndex; i--) {
        selectElement.remove(i);
    }
}

function computeNetTotal(unit) {
    let netTotal = 0;

    // Base rent
    netTotal += parseFloat(unit.rent_amount || 0);

    // Fixed & utility charges
    const chargeFields = [
        'maintenanceFees',
        'parkingFees',
        'hoaFees',
        'securityFees',
        'garbageCollectionFees',
        'petFees',
        'latePaymentFees',
        'other_charges',
        'water_bill',
        'electricity_bill'
    ];

    chargeFields.forEach(field => {
        netTotal += parseFloat(unit[field] || 0);
    });

    // Custom charges (JSON)
    if (unit.custom_charges) {
        try {
            const customCharges = JSON.parse(unit.custom_charges);
            customCharges.forEach(group => {
                Object.values(group).forEach(value => {
                    netTotal += parseFloat(value || 0);
                });
            });
        } catch (e) {
            console.warn('Invalid custom_charges JSON', e);
        }
    }

    return netTotal.toFixed(2);
}

function getPropertyUnits() {
    const unitTargetInputElement = document.querySelector('.unitTargetInputElement');

    // Clear existing options 
    clearOptionsFromIndex(unitTargetInputElement, 1);
    fetch(`/lease/users/getRespectivePropertyUnit?id=${document.querySelector('.property-change-event').value}`)
        .then(response => response.json())
        .then(handleData)
        .catch(error => {
            console.error('Error fetching data: ', error);
        });

    function handleData(data) {
        // Check if data is an array
        if (Array.isArray(data)) {
            data.forEach(options => {
                if (Array.isArray(options)) {
                    options.forEach(option => {
                        appendOption(option);
                    });
                } else {
                    // Handle single options object
                    appendOption(options);
                }
            });
        } else {
            // Handle case when data is not an array
            appendOption(data);
        }
    }

    function appendOption(option) {
        console.log(option);
        var item_id_notation = unitTargetInputElement.getAttribute('selector-id');
        var item_name_notation = unitTargetInputElement.getAttribute('selector-name');
        var item_unique_notation = unitTargetInputElement.getAttribute('selector-unique');
        var text_option;

        (Object.values(option['data'])).forEach(item => {
            if (Array.isArray(item)) {
                item.forEach(option => {
                    if (item_unique_notation.length > 0) {
                        var item_unique_notations = item_unique_notation.split(',');
                        if (item_unique_notations.length > 0) {
                            text_option = `${option[item_name_notation]} `;
                            item_unique_notations.forEach((item_unique_notation, index) => {
                                text_option += `- ${option[item_unique_notation]} `;
                            });
                        }
                    } else {
                        text_option = `${option[item_name_notation]}`;
                    }

                    var newOption = document.createElement('option');
                    newOption.value = option[item_id_notation];
                    newOption.text = text_option;
                    newOption.setAttribute('net-total', computeNetTotal(option));
                    newOption.setAttribute('rent-amount', option['rent_amount']);
                    newOption.setAttribute('start-date', option['start_date']);
                    newOption.setAttribute('end-date', option['end_date']);
                    newOption.setAttribute('agent-name', option['agent_name']);
                    unitTargetInputElement.add(newOption);
                });
            }
        });

        manipulateUnitAmount();
    }
}

function initializeSearchSelectOnTheFly() {
    var queryParameters = urlParams();
    var UserLedgerViewId = null;
    var _location = window.location.pathname;
    if (queryParameters['id'] && (_location.includes('/users/tenant/ledger') || _location.includes('/users/landlord/ledger'))) {
        UserLedgerViewId = queryParameters['id'];
    }

    try {
        $('.searchSelect').each(function (index) {
            // Fetch options for the current select element
            var currentSelect = $(this);
            var dataUrl = currentSelect.attr('data-url');
            var data_id = currentSelect.attr('data-id'); 
            var originalId = currentSelect.attr('id');
    
            // Assign a unique temporary ID (to avoid issues with duplicate IDs)
            var temporaryId = originalId + '_temp_' + index;  // Create a temporary unique ID
            currentSelect.attr('id', temporaryId);
    
            // Initialize Select2 for the current select element
            currentSelect.select2({
                width: '100%',
                dropdownParent: currentSelect.parent()
            });
    
            // After initializing Select2, revert the ID to its original value
            currentSelect.attr('id', originalId);

            if (dataUrl) {
                if (dataUrl.length > 0) {
                    $.ajax({
                        url: dataUrl,
                        type: 'GET',
                        data: {
                            id: data_id ? data_id : null
                        },
                        dataType: 'json',
                        success: function (response) {
                            $.each(response.data, function (index, options) {
                                $.each(options, function (index, option) {
                                    var item_id_notation = currentSelect.attr('selector-id');
                                    var item_name_notation = currentSelect.attr('selector-name');
                                    var item_unique_notation = currentSelect.attr('selector-unique');
                                    var text_option;
                                    if (item_unique_notation.length > 0) {
                                        var item_unique_notations = item_unique_notation.split(',');
                                        if (item_unique_notations.length > 0) {
                                            text_option = `${option[item_name_notation]} `;
                                            item_unique_notations.forEach((item_unique_notation, index) => {
                                                text_option += `- ${option[item_unique_notation]} `;
                                            });
                                        }
                                    } else {
                                        text_option = `${option[item_name_notation]}`;
                                    }

                                    var $option = $('<option>', {
                                        value: `${option[item_id_notation]}`,
                                        text: text_option
                                    });

                                    if (UserLedgerViewId && UserLedgerViewId == option[item_id_notation]) {
                                        $option.attr('selected', 'selected');
                                    }

                                    currentSelect.append($option);

                                });
                                notification(currentSelect, options)
                            });
                        },
                        error: function (error) {
                            console.log('Error fetching data: ', error);
                        }
                    });
                }
            }
        });
    } catch (error) {
        // catch error
        console.log("NET Error");
    }
}

function getExpenseSubcategory() {
    const expenseSubCategory = document.querySelector('.expenseSubCategory');

    // Clear existing options 
    clearOptionsFromIndex(expenseSubCategory, 1);
    fetch(`/expenses/categories/get-subcategories?id=${document.querySelector('.categories-field-change-event').value}`)
        .then(response => response.json())
        .then(handleData)
        .catch(error => {
            console.error('Error fetching data: ', error);
        });

    function handleData(data) {
        // Check if data is an array
        if (Array.isArray(data)) {
            data.forEach(options => {
                if (Array.isArray(options)) {
                    options.forEach(option => {
                        appendOption(option);
                    });
                } else {
                    // Handle single options object
                    appendOption(options);
                }
            });
        } else {
            // Handle case when data is not an array
            appendOption(data);
        }
    }

    function appendOption(option) {
        var item_id_notation = expenseSubCategory.getAttribute('selector-id');
        var item_name_notation = expenseSubCategory.getAttribute('selector-name');
        var item_unique_notation = expenseSubCategory.getAttribute('selector-unique');
        var text_option;

        (Object.values(option['data'])).forEach(item => {
            if (Array.isArray(item)) {
                item.forEach(option => {
                    if (item_unique_notation.length > 0) {
                        text_option = `${option[item_name_notation]} - ${option[item_unique_notation]}`;
                    } else {
                        text_option = `${option[item_name_notation]}`;
                    }

                    var newOption = document.createElement('option');
                    newOption.value = option[item_id_notation];
                    newOption.text = text_option;
                    expenseSubCategory.add(newOption);
                });
            }
        });
    }
}

function notification(currentSelect, options) {
    if (currentSelect.hasClass('property-change-event')) {
        setTimeout(() => {
            if (options.length == 0) {
                toast(
                    'warning',
                    8000,
                    "System detected there is no property with units active for reservations. Please activate, add more units or free up existing units."
                )
            }
        }, 4000);
    }
}

function reloadWindow(confirmationMessage = null) {
    window.addEventListener('beforeunload', (event) => {
        event.preventDefault();

        // Prompt the user for confirmation
        const confirmation = confirm(confirmationMessage);

        if (!confirmation) {
            // If the user cancels, cancel the reload
            event.returnValue = '';
        }
    });
}

function urlParams(url = window.location.href) {
    const searchParams = new URL(url).searchParams;
    const params = {};

    // Iterate over each parameter and add it to the params object
    for (const [key, value] of searchParams) {
        params[key] = value;
    }

    return params;
}

function paramsToQueryString(params) {
    return Object.keys(params)
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
        .join('&');
}

function UrlQueryParams(url = window.location.href) {
    const queryParams = urlParams(url); // Use the function to parse URL parameters
    const queryString = paramsToQueryString(queryParams);

    // If there are parameters, return the query string with '?', otherwise return null
    return queryString ? `?${queryString}` : '';
}

/**
 * Checks if the current browser pathname matches the given route.
 *
 * @param {string} route - The route/path to compare against the current location.
 * @returns {boolean} - Returns true if the current pathname equals the given route, otherwise false.
 */
function win_route (route) {
    if (window.location.pathname && route == window.location.pathname) {
        return true
    }

    return false;
}

function routepath () {
    return window.location.pathname;
}

/**
 * Redirects the browser to a specified path with optional query parameters.
 *
 * @param {string} path - The target URL path to navigate to.
 * @param {Object|null} params - Optional key-value pairs to be appended as query string parameters.
 * @returns {boolean|void} - Returns false if the path is empty; otherwise performs a redirect.
 */
function route(path, params = null) {
    if (path.length == 0) {
        return false;
    } else {
        var queryString = '';
        if (params !== null && typeof params === 'object') {
            queryString = '?' + Object.keys(params).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`).join('&');
        }
        window.location.href = `${path}${queryString}`;
    }
}

function ExpensesQuickPrint() {
    if (window.location.hash == '#comprehensive') {
        quickprint('PrintComprehensiveExpensesTable', 'expensesTable', 'html', 'All Expenses');
    } else if (window.location.hash == '#with-refunds') {
        quickprint('PrintExpensesWithRefundsTable', 'expensesTable', 'html', 'All Expenses');
    } else if (window.location.hash == '#with-no-refunds') {
        quickprint('PrintExpensesWithNoRefundsTable', 'expensesTable', 'html', 'All Expenses');
    } else if (window.location.hash == '#summary') {
        quickprint('PrintExpensesSummaryTable', 'expensesTable', 'html', 'All Expenses');
    }
}

function paymentMethodChanger() {
    const PaymentMethods = document.querySelectorAll('.payment_method');
    PaymentMethods.forEach(PaymentMethod => {
        if (documentContains(PaymentMethod)) {
            PaymentMethod.addEventListener('change', event => {
                var addPaymentForm = event.target.closest('.addPaymentForm'); 
                var cardPaymentForm = addPaymentForm.querySelector('.card-payment');
                var other_transactions = addPaymentForm.querySelector('.other_transactions');
                var depositAdjustment = addPaymentForm.querySelector('.depositAdjustment');
                var banktransfer = addPaymentForm.querySelector('.banktransfer');
                var cheque_payment = addPaymentForm.querySelector('.cheque_payment');
                if (event.target.value == 'card') {
                    cardPaymentForm.classList.remove('d-none');
                } else {
                    cardPaymentForm.classList.add('d-none');
                }

                if (event.target.value == 'paybill' || event.target == 'other') {
                    other_transactions.classList.remove('d-none');
                } else {
                    other_transactions.classList.add('d-none');
                }

                if (event.target.value == 'depositAdjustment') {
                    if (depositAdjustment.classList.contains('.d-none')) {
                        depositAdjustment.classList.remove('d-none');
                    }
                } else {
                    if (depositAdjustment.classList.contains('.deposit_paid')) {
                        depositAdjustment.classList.add('d-none');
                    }
                }

                if (event.target.value == 'banktransfer') {
                    banktransfer.classList.remove('d-none');
                } else {
                    banktransfer.classList.add('d-none');
                }
                
                if (event.target.value == 'cheque') {
                    cheque_payment.classList.remove('d-none');
                } else {
                    cheque_payment.classList.add('d-none');
                }
            });
        }
    });
}

function __paymentMethodChanger() {
    $('.payment_method').each(function() {
        if ($(this).length) {
            $(this).on('change', function() {
                const method = $(this).val().toLowerCase();
                var addPaymentForm = $(this).closest('.add-payment-card');
                var cardPaymentForm = addPaymentForm.find('.card-payment');
                var other_transactions = addPaymentForm.find('.other_transactions');
                var stkMobilePhoneNumber = addPaymentForm.find('.stk-push-mobile-phone');
                var depositAdjustment = addPaymentForm.find('.depositAdjustment');
                var banktransfer = addPaymentForm.find('.banktransfer');
                var cheque_payment = addPaymentForm.find('.cheque_payment');
                const payment_methods = ['card', 'depositAdjustment', 'banktransfer', 'cheque'];
                console
                if (method == 'card') {
                    cardPaymentForm.removeClass('d-none');
                } else {
                    cardPaymentForm.addClass('d-none');
                }

                if (method == 'paybill' || method == 'mpesa') {
                    stkMobilePhoneNumber.removeClass('d-none');
                } else {
                    stkMobilePhoneNumber.addClass('d-none');
                }

                if (method == 'paybill' || !payment_methods.includes(method)) {
                    other_transactions.removeClass('d-none');
                } else {
                    other_transactions.addClass('d-none');
                }

                if (method == 'depositAdjustment') {
                    if (depositAdjustment.hasClass('d-none')) {
                        depositAdjustment.removeClass('d-none');
                    }
                } else {
                    if (depositAdjustment.hasClass('deposit_paid')) {
                        depositAdjustment.addClass('d-none');
                    }
                }

                if (method == 'banktransfer') {
                    banktransfer.removeClass('d-none');
                } else {
                    banktransfer.addClass('d-none');
                }

                if (method == 'cheque') {
                    cheque_payment.removeClass('d-none');
                } else {
                    cheque_payment.addClass('d-none');
                }
            });
        }
    });
}

function parseNumberFromCurrency(currencyString, str_ret = false) {
    // Use a regex that keeps the minus sign and digits, as well as decimal points
    let cleanedString = currencyString.replace(/[^0-9.-]/g, '');
    return (str_ret) ? String(cleanedString) : (isNaN(parseFloat(cleanedString)) ? 0 : parseFloat(cleanedString));
}

function getCurrencySymbol(currencyString) { 
    const match = currencyString.match(/^([^\d.-]+)/);
    
    return match ? match[1].trim() : '';
}

function getDecimalPlaces(numberString) { 
    const number = parseFloat(numberString);
    if (isNaN(number)) {
        return 0;
    }

    const parts = numberString.split('.');
    return parts.length > 1 ? parts[1].length : 0;
}

function QuickPayInteractiveActivitiesSetup() {
    var liveGrossAmountCount = undefined;
    var decimal_place = undefined;
    var currency = '$';
    var totalRentAmountFields = document.querySelectorAll(".quick_pay_rent_amount");
    var totalDepositAmountFields = document.querySelectorAll(".quick_pay_deposit_amount");

    totalRentAmountFields.forEach(totalRentAmountField => {
        if (documentContains(totalRentAmountField)) {
            totalRentAmountField.addEventListener('change', (event) => {
                var addPaymentForm = event.target.closest('.addPaymentForm');
                var _grossbalancelivecount = addPaymentForm.querySelector('.gross-balance-live-count');
                currency = getCurrencySymbol(_grossbalancelivecount.textContent).length ? getCurrencySymbol(_grossbalancelivecount.textContent) : currency;
                decimal_place = getDecimalPlaces(parseNumberFromCurrency(_grossbalancelivecount.textContent, true));
                var totalDepositAmountField = addPaymentForm.querySelector(".quick_pay_deposit_amount");
                if (liveGrossAmountCount == undefined) {
                    liveGrossAmountCount = parseNumberFromCurrency(_grossbalancelivecount.textContent);
                }
                var rent = parseFloat((event.target.value) ? event.target.value : 0);

                var deposit = 0;

                if (documentContains(totalDepositAmountField)) {
                    deposit = parseFloat((totalDepositAmountField.value) ? totalDepositAmountField.value : 0);
                }

                var total = Number(liveGrossAmountCount) - Number(rent) - Number(deposit); 
                __append_html(formatCurrency(total, {
                    currency: currency,
                    maximumFractionDigits: (decimal_place == 0) ? 2 : decimal_place
                }), _grossbalancelivecount);
            });
        }
    });

    totalDepositAmountFields.forEach(totalDepositAmountField => {
        if (documentContains(totalDepositAmountField)) {
            totalDepositAmountField.addEventListener('change', (event) => {
                var addPaymentForm = event.target.closest('.addPaymentForm');
                var _grossbalancelivecount = addPaymentForm.querySelector('.gross-balance-live-count');
                currency = getCurrencySymbol(_grossbalancelivecount.textContent).length ? getCurrencySymbol(_grossbalancelivecount.textContent) : currency;
                decimal_place = getDecimalPlaces(parseNumberFromCurrency(_grossbalancelivecount.textContent, true));
                var totalRentAmountField = addPaymentForm.querySelector(".quick_pay_rent_amount");
                if (liveGrossAmountCount == undefined) {
                    liveGrossAmountCount = parseNumberFromCurrency(_grossbalancelivecount.textContent);
                }
                console.log(decimal_place);
                __append_html(formatCurrency((Number(liveGrossAmountCount) - (parseFloat((event.target.value) ? event.target.value : 0) - parseFloat((totalRentAmountField.value) ? totalRentAmountField.value : 0))), {
                    currency: currency,
                    maximumFractionDigits: (decimal_place == 0) ? 2 : decimal_place
                }), _grossbalancelivecount);
            });
        }
    });

    __paymentMethodChanger();
}

function __InitializeNewPaymentProcessing(invoice_id, callbackFuncs = [], event=undefined) {
    $.ajax({
        type: "GET",
        url: `/payment/new/initialize-payment-processing?id=${invoice_id}`,
        dataType: 'json',
        success: function (response) {
            if (event.target !== undefined) {
                event.target.disabled = false;
                __append_html('Pay', event.target);
            }

            if (response && response.status == 'success') {
                const quickPayModalContainer = document.querySelector('.payment-modal');
                __append_html(response.modal, quickPayModalContainer);
                __show_modal('quickPayModal');
                setTimeout(() => {
                    dateRangeInitializer(); 
                    _InitializePayment(callbackFuncs); 
                    __searchSelectInitializer();
                    __setFilesUploadArea(); 
                }, 1000);
            } else if (response && response.status == 'error') { 
                toast(response.status, 5000, response.message);
            } else {
                toast('error', 5000, 'Server error, Please try again or contact the administrator!');
            }
        },
        error: (error) => {
            console.log(error);
            if (event.target !== undefined) {
                event.target.disabled = false;
                __append_html('Pay', event.target);
            }
            toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
        }
    });
}

function __InitializeDuePaymentProcessing(invoice_id, callbackFuncs = [], target=undefined) {
    $.ajax({
        type: "GET",
        url: `/payment/due/initialize-payment-processing?id=${invoice_id}`,
        dataType: 'json',
        success: function (response) {
            if (target !== undefined) {
                target.disabled = false;
                __append_html('<i class="fa fa-money" aria-hidden="true"></i> Pay', target);
            }

            if (response && response.status == 'success') {
                const modal = document.querySelector('.payment-modal');
                __append_html(response.modal, modal);
                __show_modal('quickPayDueModal');
                setTimeout(() => {
                    dateRangeInitializer(); 
                    _InitializePayment(callbackFuncs); 
                    __searchSelectInitializer();
                    __setFilesUploadArea();
                }, 1000);
            } else if (response && response.status == 'error') {
                toast(response.status, 5000, response.message);
            } else {
                toast('error', 5000, 'Server error, Please try again or contact the administrator!');
            }
        },
        error: (error) => {
            console.log(error);
            if (target !== undefined) {
                target.disabled = false;
                __append_html('<i class="fa fa-money" aria-hidden="true"></i> Pay', target);
            }
            toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
        }
    });
}

function __InitializeBusinessSubscriptionPayment(callbackFuncs = []) {
    __paymentMethodChanger();
    const PayBtn = document.querySelector(`.payBtn`);
    if (documentContains(PayBtn)) {
        PayBtn.addEventListener('click', event => {
            event.preventDefault();
            event.target.disabled = true;
            var addPaymentForm = event.target.parentElement.parentElement;
            addPaymentForm = addPaymentForm.querySelector('.addPaymentForm');
            const formData = serializeData({
                    form: addPaymentForm,
                    class: 'create-payment-form-field',
                    validate: false,
                },
                [
                    'paymentDocuments'
                ]);

            __append_html("Payment Processing...", event.target);

            $.ajax({
                type: "POST",
                url: "/business/subscription/pay",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (response) => {
                    if (event.target !== undefined) {
                        event.target.disabled = false;
                        __append_html('<i class="fa fa-money" aria-hidden="true"></i> Pay', event.target);
                    }

                    if (response) {
                        console.log(response);
                        toast(response.status, 8000, response.message);
                    }
                    __append_html("Pay", event.target);
                    if (response.status == 'success') {
                        __quick_close_modal('.quikpayprocessingmodal');
                        reset_form("addPaymentForm", "create-payment-form-field", 'quick-pay-business');
                        if (window.location.pathname.includes('lease/create')) {
                            window.location.reload();
                        }

                        if (callbackFuncs.length > 0) {
                            setTimeout(() => {
                                callbackFuncs.forEach(callbackFunc => {
                                    callbackFunc();
                                });
                            }, 1000);
                        }
                    }
                    event.target.disabled = false;
                },
                error: (error) => { 
                    console.log(error);
                    if (event.target !== undefined) {
                        event.target.disabled = false;
                        __append_html('<i class="fa fa-money" aria-hidden="true"></i> Pay', event.target);
                    }
                    toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
                }
            });
        });
    }
}

function _InitializePayment(callbackFuncs = []) {
    const PayBtn = document.querySelector(`.payBtn`);
    dateRangeInitializer(); 
    __searchSelectInitializer();
    __setFilesUploadArea();
    QuickPayInteractiveActivitiesSetup();
    PayBtn.addEventListener('click', event => {
        event.preventDefault();
        event.target.disabled = true;
        var addPaymentForm = event.target.parentElement.parentElement;
        addPaymentForm = addPaymentForm.querySelector('.addPaymentForm');
        const formData = serializeData({
                form: addPaymentForm,
                class: 'create-payment-form-field',
                validate: false,
            },
            [
                'paymentDocuments'
            ]);

        __append_html("Payment Processing...", event.target);

        $.ajax({
            type: "POST",
            url: "/lease/payment/pay",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (response) => {
                if (response) {
                    console.log(response);
                    toast(response.status, 8000, response.message);
                }
                __append_html("Pay", event.target);
                if (response.status == 'success') {
                    reset_form("addPaymentForm", "create-payment-form-field", 'quickPayModal');
                    __quick_close_modal('.quickPayDueModal');
                    if (window.location.pathname.includes('lease/create')) {
                        window.location.reload();
                    }

                    if (callbackFuncs.length > 0) {
                        setTimeout(() => {
                            callbackFuncs.forEach(callbackFunc => {
                                callbackFunc();
                            });
                        }, 1000);
                    }
                }
                event.target.disabled = false;
            },
            error: (error) => {
                event.target.disabled = false;
                console.log(error);
                __append_html("Pay", event.target);
                toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
            }
        });
    });
}

function mergeMultiFormData(multi_form_data, formdatakey='data', attachment_name='attachments') {
    const finalFormData = new FormData();

    // Append each form data to the final FormData object
    const dict = {};
    multi_form_data.forEach((form_data, index) => { 
        const temp_data = {}; 
        var count = 0;
        for (const [key, value] of form_data.entries()) { 
            if (value instanceof File) { 
                count += 1;  
                finalFormData.append(attachment_name + '[' + count + ']' + '[' + index + ']', value);
            } else {
                temp_data[key] = value;
            }
        }  
        dict[index] = temp_data;
    });

    finalFormData.append(formdatakey, JSON.stringify(dict));

    return finalFormData;
}

function initializePayrollPaymentProcessing(callbackFuncs = []) { 
    __paymentMethodChanger();
    __searchSelectInitializer();
    __setFilesUploadArea();
    dateRangeInitializer();
    const payBtns = document.querySelectorAll('.payBtn'); 
    payBtns.forEach(payBtn => {
        const clonedPayBtn = cloneNodeElement(payBtn);
        if (documentContains(clonedPayBtn)) {
            clonedPayBtn.addEventListener('click', event => {
                event.preventDefault();
                event.target.disabled = true;
                var addPaymentForm = event.target.parentElement.parentElement; 
                const payment_type = addPaymentForm.querySelector('.payment_type');
                addPaymentForm = addPaymentForm.querySelector('.addPaymentForm');
                const subforms = Array.from(addPaymentForm.querySelectorAll('.add-payment-card'))
                                    .filter(subform => !subform.classList.contains('d-none'));
            
                const multi_form_data = [];
                subforms.forEach(form => {
                    const form_data = serializeData({
                            form: form,
                            class: 'create-payment-form-field',
                            validate: false,
                        },
                        [
                            'paymentDocuments'
                        ]
                    );

                    console.log(form_data);
                    multi_form_data.push(form_data);
                });

                const data = mergeMultiFormData(multi_form_data, 'payroll', 'attachments');
                data.append('payment_type', payment_type.value);
                data.append('payroll_type', payroll_type.value); 
                console.log(data);

                __append_html("Payment Processing...", event.target);

                $.ajax({
                    type: "POST",
                    url: "/business/payroll/pay",
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        if (response) {
                            console.log(response);
                            toast(response.status, 8000, response.message);
                        }
                        __append_html("Pay", event.target);
                        if (response.status == 'success') {
                            
                            __quick_close_modal('.quikpayprocessingmodal');
                            if (window.location.pathname.includes('lease/create')) {
                                window.location.reload();
                            }

                            if (callbackFuncs.length > 0) {
                                callbackFuncs.forEach(callbackFunc => {
                                    callbackFunc();
                                });
                            }
                        }
                        event.target.disabled = false;
                    },
                    error: (error) => {
                        event.target.disabled = false;
                        console.log(error);
                        __append_html("Pay", event.target);
                        toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
                    }
                });
            });
        }
    });
}

function InitializePayment(callbackFuncs = []) {
    const PayBtns = document.querySelectorAll('.payBtn');
    QuickPayInteractiveActivitiesSetup();
    PayBtns.forEach(PayBtn => {
        if (documentContains(PayBtn)) {
            PayBtn.addEventListener('click', event => {
                event.preventDefault();
                event.target.disabled = true;
                var addPaymentForm = event.target.parentElement.parentElement;
                addPaymentForm = addPaymentForm.querySelector('.addPaymentForm');
                const formData = serializeData({
                        form: addPaymentForm,
                        class: 'create-payment-form-field',
                        validate: false,
                    },
                    [
                        'paymentDocuments'
                    ]
                );

                __append_html("Payment Processing...", event.target);

                $.ajax({
                    type: "POST",
                    url: "/lease/payment/pay",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        if (response) {
                            console.log(response);
                            toast(response.status, 8000, response.message);
                        }
                        __append_html("Pay", event.target);
                        if (response.status == 'success') {
                            
                            __quick_close_modal('.quikpayprocessingmodal');
                            if (window.location.pathname.includes('lease/create')) {
                                window.location.reload();
                            }

                            if (callbackFuncs.length > 0) {
                                callbackFuncs.forEach(callbackFunc => {
                                    callbackFunc();
                                });
                            }
                        }
                        event.target.disabled = false;
                    },
                    error: (error) => {
                        event.target.disabled = false;
                        console.log(error);
                        __append_html("Pay", event.target);
                        toast('error', 5000, (error.message) ? error.message : 'Server error, Please try again or contact the administrator!');
                    }
                });
            });
        }
    });
}

function initializeDatepicker() {
    try {
        const dateRangeInputFields = document.querySelectorAll('.dateRange');
        var jsDateFormat = convertPhpDateFormatToJs(phpDateFormat, false);
        dateRangeInputFields.forEach(dateRangeInputField => {
            $(dateRangeInputField).datepicker({
                format: jsDateFormat,
                autoclose: false,
                todayHighlight: false,
                multidate: true,
                multidateSeparator: ' - '
            }).on('changeDate', function (e) {
                var selectedDates = $(this).datepicker('getDates');
                if (selectedDates.length > 2) {
                    // Remove the last selected date
                    selectedDates.pop();
                    // Set the selected dates again
                    $(this).datepicker('setDates', selectedDates);
                }
            });
            
            // Get today's date
            var today = new Date();

            // Get the start of the current month
            var startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

            // Get the end of the current month
            var endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            // Set the date range to cover the entire current month
            $(dateRangeInputField).datepicker('setDates', [startOfMonth, endOfMonth]);
        });
    } catch (error) {
        // Catch error
        console.log("NET Error.");
    }
}

function _clearOptionsFromIndex(selectElement, startIndex) {
    $(selectElement).find('option').slice(startIndex).remove();
}

function searchSelectInitializer() {
    var queryParameters = urlParams();
    var UserLedgerViewId = null;
    var _location = window.location.pathname;
    if (queryParameters['id'] && _location.includes('/users/ledger/view')) {
        UserLedgerViewId = queryParameters['id'];
    }

    $('.searchSelect1').each(function (index) {
        // Fetch options for the current select element
        var currentSelect = $(this);
        var dataUrl = currentSelect.attr('data-url'); 
        var originalId = currentSelect.attr('id');

        // Assign a unique temporary ID (to avoid issues with duplicate IDs)
        var temporaryId = originalId + '_temp_' + index;  // Create a temporary unique ID
        currentSelect.attr('id', temporaryId);

        // Initialize Select2 for the current select element
        currentSelect.select2({
            width: '100%',
            dropdownParent: currentSelect.parent()
        });

        // After initializing Select2, revert the ID to its original value
        currentSelect.attr('id', originalId);
        
        if (dataUrl) {
            if (dataUrl.length > 0) {
                $.ajax({
                    url: dataUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $.each(response.data, function (index, options) {
                            $.each(options, function (index, option) {
                                var item_id_notation = currentSelect.attr('selector-id');
                                var item_name_notation = currentSelect.attr('selector-name');
                                var item_unique_notation = currentSelect.attr('selector-unique');
                                var text_option;
                                if (item_unique_notation.length > 0) {
                                    text_option = `${option[item_name_notation]} - ${option[item_unique_notation]}`;
                                } else {
                                    text_option = `${option[item_name_notation]}`;
                                }

                                var $option = $('<option>', {
                                    value: `${option[item_id_notation]}`,
                                    text: text_option
                                });

                                if (UserLedgerViewId && UserLedgerViewId == option[item_id_notation]) {
                                    $option.attr('selected', 'selected');
                                }

                                currentSelect.append($option);

                            });
                            notification(currentSelect, options)
                        });
                    },
                    error: function (error) {
                        console.log('Error fetching data: ', error);
                    }
                });
            }
        }
    });

    $('.searchSelect1').on('select2:open', function() {
        // Apply z-index to the search field
        $('.select2-container--open .select2-search--dropdown .select2-search__field').css('z-index', '10000');
    });
}

function searchSelectQuery(selector, action) {
    // Initialize Select2 for the current select element  
    $(selector).select2({
        width: '100%', 
        dropdownParent: $(selector).parent(),
        placeholder: 'Search here...',
        allowClear: true,
        ajax: {
            url: action,
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    qqq: params.term,
                };
            },
            processResults: function (data) {  
                return {
                    results: data.map(function (item) {
                        return { 
                            id: item.op_value,
                            text: item.op_text,
                        };
                    }),
                };
            },
            cache: true,
            error: function (xhr, status, error) {
                console.error('AJAX request failed:', error); 
            },
        },
        minimumInputLength: 2,
        tags: true,
    });
}

function __searchSelectInitializer() {
    var queryParameters = urlParams();
    var UserLedgerViewId = null;
    var _location = window.location.pathname;
    if (queryParameters['id'] && _location.includes('/users/ledger/view')) {
        UserLedgerViewId = queryParameters['id'];
    }

    $('.searchSelect').each(function (index) { 
        // Fetch options for the current select element
        var currentSelect = $(this);
        var dataUrl = currentSelect.attr('data-url'); 
        var originalId = currentSelect.attr('id');

        // Assign a unique temporary ID (to avoid issues with duplicate IDs)
        var temporaryId = originalId + '_temp_' + index;  // Create a temporary unique ID
        currentSelect.attr('id', temporaryId);

        // Initialize Select2 for the current select element
        currentSelect.select2({
            width: '100%',
            dropdownParent: currentSelect.parent()
        });

        // After initializing Select2, revert the ID to its original value
        currentSelect.attr('id', originalId); 
        
        if (dataUrl) {
            if (dataUrl.length > 0) {
                $.ajax({
                    url: dataUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $.each(response.data, function (index, options) {
                            $.each(options, function (index, option) {
                                var item_id_notation = currentSelect.attr('selector-id');
                                var item_name_notation = currentSelect.attr('selector-name');
                                var item_unique_notation = currentSelect.attr('selector-unique');
                                var text_option;
                                if (item_unique_notation.length > 0) {
                                    if (option[item_unique_notation]) {
                                        text_option = `${option[item_name_notation]} - ${option[item_unique_notation]}`;
                                    }
                                    else {
                                        text_option = `${option[item_name_notation]}`;
                                    }
                                } else {
                                    text_option = `${option[item_name_notation]}`;
                                }

                                var $option = $('<option>', {
                                    value: `${option[item_id_notation]}`,
                                    text: text_option
                                });

                                if (UserLedgerViewId && UserLedgerViewId == option[item_id_notation]) {
                                    $option.attr('selected', 'selected');
                                }

                                currentSelect.append($option);

                            });
                            notification(currentSelect, options)
                        });
                    },
                    error: function (error) {
                        console.log('Error fetching data: ', error);
                    }
                });
            }
        }
    });
    
}

/**
 * Initializes Select2 with live search from API endpoint
 * 
 * @param {string} endpoint - Route URL for fetching search data
 * @param {number} minInputLength - Minimum characters to trigger search (default: 2)
 * @param {number} delay - Debounce delay in milliseconds (default: 500)
 */
function searchSelectUtilFunction(selector = '.searchSelect', endpoint = '', minInputLength = 2, delay = 500) {
    $(selector).each(function () {
        const currentSelect = $(this); 

        // Destroy existing instance
        if (currentSelect.hasClass("select2-hidden-accessible")) {
            currentSelect.select2('destroy');
        }

        // Determine parent (modal or default)
        let parent;
        const modal = currentSelect.closest('.modal');
        
        if (modal.length > 0) {
            parent = modal;
        } else {
            parent = $(document.body);
        }
            
        if (endpoint.length == 0) {
            currentSelect.select2({
                width: '100%',
                dropdownParent: parent, // Use modal as parent
                dropdownAutoWidth: true
            });
            return;
        }

        currentSelect.select2({
            width: '100%',
            dropdownParent: parent, // Use modal as parent
            placeholder: currentSelect.attr('placeholder') || 'Search...',
            allowClear: true,
            minimumInputLength: minInputLength,
            ajax: {
                url: endpoint,
                dataType: 'json',
                delay: delay,
                data: function (params) 
                {
                    return {
                        search: params.term,
                        page: params.page || 1,
                        context: currentSelect.data('context'),
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items || data,
                        pagination: {
                            more: data.more || false
                        }
                    };
                },
                cache: true
            },
            templateResult: function (item) {
                if (item.loading) return item.text;
                return $('<div>').text(item.text).addClass('select2-result-item');
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
}

function date_today() {
    // Get the current date
    var currentDate = new Date();

    // Format the date as YYYY-MM-DD
    var year = currentDate.getFullYear();
    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2); // Months are zero-indexed
    var day = ('0' + currentDate.getDate()).slice(-2);

    // Construct the formatted date string
    var formattedDate = year + '-' + month + '-' + day;

    return formattedDate;
}

function removeKeys(obj, keysToRemove) {
    const newObj = {
        ...obj
    }; // Create a shallow copy of the original object
    keysToRemove.forEach(key => {
        delete newObj[key]; // Delete the specified key from the copied object
    });
    return newObj; // Return the modified object
}

// Move to the next input when typing
function moveToNext(current, nextFieldID) {
    if (current.value.length === 1 && nextFieldID) {
        document.getElementById(nextFieldID)?.focus();
    }
}

// Move to the previous input when backspacing on an empty field
function moveToPrevious(event, current, previousFieldID) {
    if (event.key === "Backspace" && current.value === '' && previousFieldID) {
        document.getElementById(previousFieldID)?.focus();
    }
}

// Communication scripts
function showQRCode(qrCodeSectionId) {
    document.getElementById("contactOptions").style.display = "none";
    document.getElementById("contactForm").style.display = "none";
    document.getElementById("ticketForm").style.display = "none";
    document.getElementById("qrCodeDisplay").style.display = "block";
    
    // Hide all QR code sections first
    document.getElementById("telegramQRCodeSection").style.display = "none";
    document.getElementById("whatsappQRCodeSection").style.display = "none";
    
    // Show the selected QR code section
    document.getElementById(qrCodeSectionId).style.display = "block";
    document.getElementById("backButton").style.display = "inline-block";
}

function showContactForm() {
    document.getElementById("contactOptions").style.display = "none";
    document.getElementById("qrCodeDisplay").style.display = "none";
    document.getElementById("ticketForm").style.display = "none";
    document.getElementById("contactForm").style.display = "block";
    document.getElementById("backButton").style.display = "inline-block";
}

function showTicketForm() {
    document.getElementById("contactOptions").style.display = "none";
    document.getElementById("qrCodeDisplay").style.display = "none";
    document.getElementById("contactForm").style.display = "none";
    document.getElementById("ticketForm").style.display = "block";
    document.getElementById("backButton").style.display = "inline-block";
    __setFilesUploadArea(); 
}

function showContactOptions() {
    document.getElementById("qrCodeDisplay").style.display = "none";
    document.getElementById("contactForm").style.display = "none";
    document.getElementById("ticketForm").style.display = "none";
    document.getElementById("backButton").style.display = "none";
    document.getElementById("contactOptions").style.display = "block";
}
// /Communication scripts

// backup settings 

function toggleFields(selectId) {
    // Get the selected value
    const selectedValue = document.getElementById(selectId).value;

    // Get all the fields to toggle
    const toggleFields = document.querySelectorAll('.toggle-field');

    // Loop through all the fields and show/hide them based on the selected value
    toggleFields.forEach(function(field) {
        if (field.getAttribute('data-toggle') === selectedValue) {
            field.style.display = 'flex';  // Show the selected section (use 'flex' to align form fields)
        } else {
            field.style.display = 'none';  // Hide the unselected sections
        }
    });
}

// /backup settings 

function btnNotWorkingNotification(selector = 'unimplemented-btn') { 
    $(`.${selector}`).on('click', function() {
        toast('error', 5000, "This feature is not yet fully implemented. Stay tuned!");
    });
}

function navigationFunction(event, targetClass, targetDataId=undefined) {
    // Remove 'nav-active' from all tabs
    document.querySelectorAll('.navigation-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Toggle visibility of content sections
    document.querySelectorAll(targetClass).forEach(section => {
        if (section.classList.contains('d-none')) {
            section.classList.remove('d-none');
            if (targetDataId !== undefined) {
                document.querySelector(targetDataId).value = event.target.getAttribute('data-id');
            }
        } else {
            section.classList.add('d-none');
        }
    });
    
    // Add 'nav-active' to clicked tab
    event.target.classList.add('active'); 
}

/**
 * Initialize TinyMCE on all text area sections
 * 
 * @returns {void} None
 */
function initializeTinyMce(selectors=['.editor', '.template-editor', '.message-editor'], settings = {}) {
    if (!Array.isArray(selectors)) selectors = [selectors];

    selectors.forEach(sel => {
        document.querySelectorAll(sel).forEach(el => {

            if (!el.id) {
                el.id = 'tmce-' + Math.random().toString(36).substring(2, 9);
            }

            if (tinymce.get(el.id)) {
                tinymce.get(el.id).remove();
            }

            tinymce.init({
                target: el,

                // SIZE
                height: 450,

                // UI
                menubar: true,
                branding: false,
                promotion: false,

                // FULL FEATURE PLUGINS
                plugins: `
                    advlist autolink autosave
                    code preview
                    link image media
                    lists table
                    fullscreen
                    searchreplace
                    visualblocks visualchars
                    wordcount
                    insertdatetime
                    charmap
                    anchor
                    quickbars
                `,

                // FULL FEATURE TOOLBAR
                toolbar: `
                    undo redo |
                    blocks fontfamily fontsize |
                    bold italic underline strikethrough forecolor backcolor |
                    alignleft aligncenter alignright alignjustify |
                    bullist numlist outdent indent |
                    link image media charmap |
                    table | insertdatetime |
                    removeformat |
                    code preview fullscreen
                `,

                // BLOCK FORMATS (headings)
                block_formats: `
                    Paragraph=p;
                    Heading 1=h1;
                    Heading 2=h2;
                    Heading 3=h3;
                    Heading 4=h4;
                    Heading 5=h5;
                    Heading 6=h6;
                    Blockquote=blockquote;
                    Code=pre
                `,

                // FONT SIZES
                fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 24px 28px 32px 36px 48px 60px',

                // FONTS
                font_family_formats: `
                    Arial=arial,helvetica,sans-serif;
                    Arial Black=arial black,avant garde;
                    Book Antiqua=book antiqua,palatino;
                    Georgia=georgia,palatino;
                    Helvetica=helvetica;
                    Impact=impact,chicago;
                    Tahoma=tahoma,arial,helvetica,sans-serif;
                    Times New Roman=times new roman,times;
                    Verdana=verdana,geneva;
                    Courier New=courier new,courier,monospace
                `,

                // QUICK ACTIONS TOOLBAR (select text to see it)
                quickbars_insert_toolbar: 'quickimage quicktable hr',
                quickbars_selection_toolbar: 'bold italic underline | forecolor backcolor | h2 h3 blockquote',

                // AUTOSAVE OPTIONS
                autosave_interval: '20s',
                autosave_prefix: 'tinymce-autosave-{path}{query}-{id}-',
                autosave_restore_when_empty: true,

                // IMAGE + MEDIA SETTINGS
                image_advtab: true,
                image_caption: true,

                // PASTE SETTINGS
                paste_data_images: true,
                paste_as_text: false,

                // CONTENT CSS for nicer formatting
                content_style: `
                    body { font-family: Arial, sans-serif; line-height: 1.6; padding: 10px; }
                    img { max-width: 100%; height: auto; }
                `,
            });
        });
    });
}

/**
 * Shows and Hides the navbar search bar - absolute position blocked.
 * Uses animation library for smooth & stable transition effect
 * 
 * @returns {void} void
 */
function handleShowNavbarSearchBarToggler() {
    const searchBox = document.getElementById('search_input_box');
    const closeBtn = document.getElementById('close_search');

    if (!searchBox || !closeBtn) return;

    searchBox.classList.remove('d-none');
    searchBox.classList.add('animate__animated', 'animate__fadeInDown');

    closeBtn.addEventListener('click', () => {
        searchBox.classList.remove('animate__fadeInDown');
        searchBox.classList.add('animate__fadeOutUp');

        searchBox.addEventListener('animationend', () => {
            searchBox.classList.add('d-none');
            searchBox.classList.remove('animate__animated', 'animate__fadeOutUp');
        }, {
            once: true
        });
    });
}

/**
 * Temporarily changes button text, & restores original text when revert is true.
 * 
 * @param {HTMLButtonElement} button HTML button element to act on.
 * @param {Text} tempContent Text to apply to the button.
 * @param {Boolean} revet True or false: To Change back to original content or not.
 */
function toggleButtonContent(button, tempContent = '<i class="fas fa-spinner fa-spin me-3"></i> Please wait...', revert = false) {
    if (!button) return;

    if (!revert) {
        // Save original content to data attribute
        button.dataset.originalContent = button.innerHTML;
        button.innerHTML = tempContent;
    } else {
        // Restore original content
        if (button.dataset.originalContent) {
            button.innerHTML = button.dataset.originalContent;
            delete button.dataset.originalContent;
        }
    }
}

/**
 * Disables one or multiple HTML elements.
 * Accepts a CSS selector string, an HTMLElement, or a NodeList/array of elements.
 *
 * @param {string | HTMLElement | NodeList | Array} selector - The target element(s) to disable.
 */
function disableElement(selector) {
    let elements;

    if (typeof selector === 'string') {
        elements = document.querySelectorAll(selector);
    } else if (selector instanceof HTMLElement) {
        elements = [selector];
    } else if (selector instanceof NodeList || Array.isArray(selector)) {
        elements = selector;
    } else {
        console.warn('Unsupported selector type:', selector);
        return;
    }

    elements.forEach(element => {
        element.disabled = true;
    });
}

/**
 * Enables one or multiple HTML elements.
 * Accepts a CSS selector string, an HTMLElement, or a NodeList/array of elements.
 *
 * @param {string | HTMLElement | NodeList | Array} selector - The target element(s) to enable.
 */
function enableElement(selector) {
    let elements;

    if (typeof selector === 'string') {
        elements = document.querySelectorAll(selector);
    } else if (selector instanceof HTMLElement) {
        elements = [selector];
    } else if (selector instanceof NodeList || Array.isArray(selector)) {
        elements = selector;
    } else {
        console.warn('Unsupported selector type:', selector);
        return;
    }

    elements.forEach(element => {
        element.disabled = false;
    });
}

/**
 * Disable button and show spinner or loading text
 * 
 * @param {Element} btn 
 * @param {String} text 
 * @returns {void}
 */
function btnLoading(btn, text = '') { 
    if (!btn) return;
    disableElement(btn);
    toggleButtonContent(btn, text || 'Sending...');
}

/**
 * Enable button and restore original text
 * 
 * @param {Element} btn 
 * @param {String} text 
 * @returns {void}
 */
function btnReset(btn, text = '') {
    if (!btn) return;
    enableElement(btn);
    toggleButtonContent(btn, text, true);
}

/**
 * Parses and returns an action route from a specifified form
 * 
 * @param {HTMLSelectElement} form 
 * @returns {string|null} Form Route URL
 */
function formRouteParser(form) {
    return form.action || form.getAttribute('route')
}

/**
 * Accepts form DOM and resets the form fields,
 * skipping elements marked with data-no-reset="true".
 * Closes the modal if the form exists inside a modal.
 *
 * @param {HTMLFormElement} form
 */
 function resetFormAndCloseModal(form) {

    if (!documentContains(form)) return;

    form.querySelectorAll('input, textarea, select').forEach(element => {

        // Exception: Skip reset
        if (element.dataset.noReset === "true") return;

        // Handle TinyMCE textarea
        if (element.tagName === 'TEXTAREA' && window.tinymce) {

            const editor = tinymce.get(element.id);

            if (editor) {
                editor.setContent('');
                return;
            }
        }

        switch (element.type) {

            case 'checkbox':
            case 'radio':
                element.checked = false;
                break;

            case 'select-one':
            case 'select-multiple':

                // Handle Select2 (searchSelect)
                if (element.classList.contains('searchSelect') && window.jQuery) {
                    $(element).val(null).trigger('change');
                } else {
                    element.selectedIndex = -1;
                }

                break;

            case 'file':
                element.value = null;
                break;

            default:
                element.value = '';
        }
    });

    // Remove validation classes
    form.querySelectorAll('.is-valid, .is-invalid').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    });

    // Clear file preview lists
    clearFileList();

    // close the modal 
    // if the form parent is a modal
    closeModal(form);
}

/**
 * Clears file preview/list containers.
 *
 * @param {string|HTMLElement|NodeList} fileList
 */
function clearFileList(fileList = '.fileList') {

    let containers = [];

    if (typeof fileList === 'string') {
        containers = document.querySelectorAll(fileList);
    } 
    else if (fileList instanceof HTMLElement) {
        containers = [fileList];
    } 
    else if (fileList instanceof NodeList || Array.isArray(fileList)) {
        containers = fileList;
    }

    containers?.forEach(container => {
        container.innerHTML = '';

        if (container.parentElement) {
            container.parentElement.style.display = 'none';
        }
    }); 
}

/**
 * Closes the modal if modal appears to be the parent container 
 * of the element specified.
 * 
 * @param {Element} domEl 
 */
function closeModal(domEl) {
    // Check if the form is inside a modal
    let modal = domEl?.closest('.modal');
    if (modal) {
        let modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();

            $(modal).find('.searchSelect').each(function() {
                if ($(modal).hasClass('select2-hidden-accessible')) {
                    $(modal).select2('destroy');
                }
            });
        }
    }
}

/**
 * Resolve the nearest HTMLFormElement from a trigger element.
 *
 * @param {HTMLElement} trigger - Button or child element inside the form
 * @param {number} maxDepth - Safety limit to prevent infinite traversal
 * @returns {HTMLFormElement|null}
 */
function resolveClosestForm(trigger, maxDepth = 25) {
    if (!(trigger instanceof HTMLElement)) {
        console.error('resolveClosestForm: invalid trigger element', trigger);
        return null;
    }

    // Fast native path
    if (trigger.form instanceof HTMLFormElement) {
        return trigger.form;
    }

    let current = trigger;
    let depth = 0;

    while (current && depth < maxDepth) {
        if (current instanceof HTMLFormElement) {
            console.log(current);
            return current;
        }

        // closest() is faster if DOM is intact
        const found = current.closest('form');
        if (found instanceof HTMLFormElement) {
            return found;
        }

        current = current.parentElement;
        depth++;
    }

    console.warn('resolveClosestForm: form not found', trigger);
    return null;
}

/**
 * Inserts or appends HTML content into an element.
 *
 * @param {string|number} content - The HTML string|number to insert.
 * @param {HTMLElement} elementOrSelector - The target DOM element.
 * @param {boolean} [append=false] - If true, appends content; otherwise, replaces it.
 * @param {string|null} [insertBeforeSelector=null] - Optional CSS selector to insert before a specific child.
 */
function append_html(content, elementOrSelector, append = false, insertBeforeSelector = null) {
    const element = typeof elementOrSelector === 'string'
        ? document.querySelector(elementOrSelector)
        : elementOrSelector;
        
    // Prepare content as DOM nodes
    const wrapper = document.createElement('div');
    wrapper.innerHTML = content;
    const fragment = document.createDocumentFragment();
    Array.from(wrapper.childNodes).forEach(node => fragment.appendChild(node));

    // Insert logic
    if (insertBeforeSelector) {
        const insertBeforeEl = element.querySelector(insertBeforeSelector);
        if (insertBeforeEl) {
            element.insertBefore(fragment, insertBeforeEl);
        } else {
            console.warn(`__append_html: Selector '${insertBeforeSelector}' not found. Appending to end.`);
            element.appendChild(fragment);
        }
    } else if (append) {
        element.appendChild(fragment);
    } else {
        element.innerHTML = '';
        element.appendChild(fragment);
    }
}

/**
 * Adds a 'sticky' class to the navbar when the page is scrolled,
 * enabling sticky behavior for elements with 'scrollStickyNav' class.
 */
function stickNavbarOnScroll() {
    const nav = document.querySelector('.scrollStickyNav'); 
    
    window.addEventListener('scroll', function () {
        if (window.scrollY > 0) {
            if (documentContains(nav)) nav.classList.add('fixed-top'); 
        } else {
            if (documentContains(nav)) nav.classList.remove('fixed-top'); 
        } 
    });
}

/**
 * Fire up the search select library for initialization 
 * on modal select elements
 */
function fireUpSearchSelectFuncOnModals() {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {
        if (!modal) return;
        modal.addEventListener('shown.bs.modal', () => {
            searchSelectInitializer();
        })
    });
}

// DOM Manipulation Utils

/**
 * Checks if the given HTML element has the specified class.
 *
 * @param {Element} element Any valid DOM element.
 * @param {string} className The class name to check for.
 * @returns {boolean} True if the element has the class, & false otherwise.
 */
function containsClass(element, className) {
    if (!(element instanceof Element)) {
        console.warn('Argument parsed is not a valid DOM element.');
        return false;
    }

    return element.classList.contains(className);
}

// DT TABLE Utils

/**
 * Get DataTables language configuration with optional customizations.
 *
 * @param {Object} overrides Optional overrides for the language strings.
 * @returns {Object} Language configuration object for DataTables.
 */
function getDataTableLanguage(overrides = {}) {
    const defaultLanguage = {
        emptyTable: 'No data found.',
        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>',
        search: 'Search:',
        searchPlaceholder: '',
        lengthMenu: 'Show _MENU_ entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        infoFiltered: '(filtered from _MAX_ total entries)',
        paginate: {
            first: '<i class="fa fa-angle-double-left"></i> First',
            last: 'Last <i class="fa fa-angle-double-right"></i>',
            previous: '<i class="fa fa-angle-left"></i> Previous',
            next: 'Next <i class="fa fa-angle-right"></i>'
        }
    };

    // Deep merge for nested `paginate` object
    if (overrides.paginate) {
        overrides.paginate = {
            ...defaultLanguage.paginate,
            ...overrides.paginate
        };
    }

    return {
        ...defaultLanguage,
        ...overrides
    };
}

// Version with customizable default date ranges:
function filtersParser(selector, dateRangeDays = 30) {
    const container = document.querySelector(selector);
    if (!documentContains(container)) return {};

    const filters = {};
    const inputs = container.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        const name = input.name;
        let value;

        // Handle Select2 inputs
        if (containsClass(input, 'searchSelect')) {
            value = $(input).val(); // Get Select2 value
        } else {
            value = input.value;
        }

        if (name) {
            filters[name] = value;
        }
    });

    // Set default fromDate if missing or empty
    if (!filters.hasOwnProperty('fromDate') || 
        !filters.fromDate || 
        filters.fromDate.trim() === '') {
        const fromDate = new Date();
        fromDate.setDate(fromDate.getDate() - dateRangeDays);
        filters.fromDate = fromDate.toISOString().split('T')[0];
    }

    // Set default toDate if missing or empty
    if (!filters.hasOwnProperty('toDate') || 
        !filters.toDate || 
        filters.toDate.trim() === '') {
        const toDate = new Date();
        filters.toDate = toDate.toISOString().split('T')[0];
    }

    return filters;
}

/**
 * Watches inputs in a container and triggers a callback on change.
 * 
 * @param {string} selector - The CSS selector for the filters container.
 * @param {Array|Function} callback - The function|Array of Functions, to call when any input changes.
 */
function watchFilterChanges(selector, callback) { 
    let container = document.querySelector(selector);  
    if (!documentContains(container)) return;

    const inputs = container.querySelectorAll('input, textarea'); 
    const dropdownItems = container.querySelectorAll('.dropdown-item'); 

    function fireCallback(event, value) {
        if (Array.isArray(callback)) {
            callback.forEach(func => {
                func();
            });
        } else {
            callback(event, value);
        }
    }
    // Prevent multiple listeners using a WeakSet
    if (!container._watchInitialized) {
        container._watchInitialized = true;
        inputs.forEach(input => {
            input = cloneNodeElement(input); 
            if (!containsClass(input, 'searchSelect')) {   
                input.addEventListener('change', (event) => { 
                    fireCallback(event, input.value);
                });
            }
        });

        searchSelectUtilFunction();
        $(container).on('select2:select', '.searchSelect', function (event) {
            const value = $(this).val();  
            console.log(value);
            fireCallback(event, value);
            return;
        });

        dropdownItems.forEach(item => { 
            item.addEventListener('click', (event) => {
                event.preventDefault();   
                const input = container.querySelector('.daterange');
                if (input) { 
                    input.dispatchEvent(new Event('change')); 
                }
                
                fireCallback(event, value);
            });
        });
    }
}

/**
 * Assistive function for ajax complete callback
 * 
 * @param {Array|Function} callbackFunc 
 */
function ajaxCompleteFilterUtilFunc(selector, callback) {
    $(document).on('ajaxComplete', (e, jqxhr, settings) => {
        watchFilterChanges(selector, callback)
    });
}

/**
 * Ajax Dt Util helper function.
 * Parses the expected server response, and passes on to the ajax dt table api
 */
function ajaxDtParser(method, url, data = {}, callbackFuncs = []) {
    return {
        type: method,
        url: url,
        data: data,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        dataSrc: function (response) {
            if (Array.isArray(callbackFuncs) && callbackFuncs.length) {
                callbackFuncs.forEach(item => {
                    if (typeof item === 'function' && item.callback) {
                        item(response.data ?? []);
                    } else if (typeof item === 'object' && item.callback) {
                        const params = item.params ? item.params : {};
                        item.callback({
                            params: params,
                            data: response.data
                        });
                    }
                });
            }

            return response.data;
        },
        error: (err) => {
            console.log(err.message || err);
            toast('error', 3000, lang.undefined_error);
        }
    }
}

/**
 * Computes the total sum for a specific DataTable column (e.g index 6)
 * using only the currently displayed page.
 *
 * - Strips out any non-numeric characters (e.g. currency symbols, commas)
 * - Safely parses values to numbers
 * - Aggregates the column values into a single total
 *
 * @param {DataTables.Api} api DataTables API instance
 * @param {Number} col DataTables column index
 * @returns {number} The computed total for the current page
 */
function computeFooterTotals(api, col) {
    return api
        .column(col, { page: 'current' })
        .data()
        .reduce(function (sum, value) {
            // Handle any formatting, currency symbols, etc.
            var cleanValue = String(value).replace(/[^0-9.-]+/g, "");
            var num = parseFloat(cleanValue) || 0; 
            return (sum + num); 
        }, 0);
}

/**
 * Auto-computes footer totals for columns whose header has `total_compute="true"`,
 * dynamically resolving column indexes and writing results to the correct footer cells.
 *  
 * @param {DataTables.Api} api DataTables API instance
 */
function computeFooterTotalsUtil(api) {
    api.columns().every(function () {
        var header = this.header();
        var footer = this.footer();
    
        var shouldCompute = $(header).attr('total_compute') === 'true';
        if (!shouldCompute) return;
    
        var total = computeFooterTotals(api, this.index());
        var rowData = api.row({ page: 'current' }).data();
        var currency = rowData?.currency || 'KSH';
    
        var formattedTotal = formatCurrency(total, {
            currency: currency,
            maximumFractionDigits: 2
        });
    
        if (footer) {
            $(footer).html(
                '<div class="text-right"><strong>' + formattedTotal + '</strong></div>'
            );
        }
    });
}

// Templating settings
function filterTemplates() {
    const searchInput = document.getElementById('templateSearch').value.toLowerCase();
    const templateItems = document.getElementsByClassName('template-item');
    
    let visibleCount = 0;
    
    for (let item of templateItems) {
        const templateName = item.getAttribute('data-name').toLowerCase();
        if (templateName.includes(searchInput)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    }
    
    document.getElementById('templateCount').innerText = visibleCount + ' Templates Available';
}

function expandAllTemplates() {
    const collapseElements = document.querySelectorAll('.accordion-collapse');
    collapseElements.forEach(el => {
        if (!el.classList.contains('show')) {
            new bootstrap.Collapse(el, { toggle: true });
        }
    });
}

function initializeAttachmentPicker(container = document) {

    const $container = $(container);

    //Browse click
    $container.on('click', '.attachment-browse', function () {
        $(this).closest('.input-group').find('.attachment-file').trigger('click');
    });

    //File selected
    $container.on('change', '.attachment-file', function () {
        let fileName = this.files.length ? this.files[0].name : 'No file chosen';

        $(this)
            .closest('.input-group')
            .find('.attachment-name')
            .val(fileName);
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Call functions Below. 
document.addEventListener('DOMContentLoaded', async () => {
    document.querySelectorAll('.searchToggle').forEach(toggler => {
        toggler.addEventListener('click', handleShowNavbarSearchBarToggler);
    });

    initializeTinyMce();
    stickNavbarOnScroll();
    searchSelectUtilFunction();
    fireUpSearchSelectFuncOnModals();
});