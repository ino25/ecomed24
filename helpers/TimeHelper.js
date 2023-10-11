function utcDate(d) {
    d = new Date(d);
    return d.getUTCDate() + '-' + (d.getUTCMonth() + 1) + '-' + d.getUTCFullYear();
}

module.exports = {
    utcDate,
};