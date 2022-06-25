const warnfunc = (input, warn, msg) => {
    const inp = document.getElementById(input).value;
    if(inp.length < 4) {
        document.getElementById(warn).innerHTML = msg + ' must have at least 4 characters';
    } else if(inp.length > 20) {
        document.getElementById(warn).innerHTML = msg + ' must have no more than 20 characters';
    } else {
        document.getElementById(warn).innerHTML = '';
    }
}