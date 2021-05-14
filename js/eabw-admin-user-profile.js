const social_preset_icons = {
    'Facebook': 'facebook-square',
    'GitHub': 'github-square',
    'Instagram': 'instagram-square',
    'LinkedIn': 'linkedin',
    'Pinterest': 'pinterest-square',
    'Reddit': 'reddit-square',
    'Snapchat': 'snapchat-square',
    'Twitter': 'twitter-square',
    'YouTube': 'youtube-square' 
};

function addRow(tableId, selectId) {
    var table = document.getElementById(tableId);
    var select = document.getElementById(selectId);
    var preset = select.value;

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell1 = row.insertCell(0);
    populateIconCell(cell1, preset);

    var cell2 = row.insertCell(1);
    populateServiceCell(cell2, preset);

    var cell3 = row.insertCell(2);
    populateLinkCell(cell3, preset);

    var cell4 = row.insertCell(3);
    populateDeleteCell(cell4, tableId, row);

    jQuery('#' + tableId).tableDnDUpdate();
}

function deleteRow(element) {
    if (typeof(element) == "object") {
        jQuery(element).closest("tr").remove();
    } else {
        return false;
    }
}

function populateIconCell(cell, preset) {
    cell.className = 'eabw-social-icon'
    
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'eabw-txtIcon[]';
    cell.appendChild(input);

    if (preset !== 'other') {
        input.hidden = true;
        var tag = document.createElement('i');
        var icon = social_preset_icons[preset] || 'first-order';
        input.value = icon;
        tag.className = 'fab fa-' + icon + ' color';
        cell.appendChild(tag);
    }
}

function populateServiceCell(cell, preset) {
    cell.className = 'eabw-social-service'

    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'eabw-txtCustom[]';
    input.value = preset;
    input.hidden = true;
    cell.appendChild(input);

    var input2 = document.createElement('input');
    input2.type = 'text';
    input2.name = 'eabw-txtService[]';
    cell.appendChild(input2);
    
    if (preset !== 'other') {
        input2.hidden = true;
        input2.value = preset;
        var text = document.createTextNode(preset);
        cell.appendChild(text);
    }
}

function populateLinkCell(cell, preset) {
    cell.className = 'eabw-social-link'
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'eabw-txtLink[]';
    cell.appendChild(input);
}

function populateDeleteCell(cell, tableId, row) {
    cell.className = 'eabw-social-delete';
    var tag = document.createElement('i');
    tag.className = 'fa fa-trash-alt';
    tag.onclick = () => deleteRow(tableId, row);
    cell.appendChild(tag);
}