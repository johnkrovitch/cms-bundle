// Used to merge default object options with options defined by caller
export default {
    merge(options, defaultOptions) {
        options = options || {};

        return Object.assign(defaultOptions, options);
    }
}
