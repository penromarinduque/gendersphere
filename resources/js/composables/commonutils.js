// src/composables/useCommonUtils.js

import { useConfirm } from 'primevue/useconfirm'

export function useCommonUtils() {
  const confirm = useConfirm()

  const capitalizeFirstLetter = (str) => {
    if (!str) return ''
    return str.charAt(0).toUpperCase() + str.slice(1)
  }

  /**
   * Shows a confirmation dialog for delete actions
   * @param {Event} event - DOM event (used for dialog position)
   * @param {*} arg2 - Either ID or delete function
   * @param {Function} [arg3] - Delete function
   * @param {Object} [arg4] - Optional UI customization
   */
  const confirmDelete = (event, arg2, arg3, arg4) => {
    let deleteFn, payload = null, options = {}

    if (typeof arg2 === 'function') {
      // Usage: confirmDelete(event, deleteFn, options)
      deleteFn = arg2
      options = arg3 || {}
    } else {
      // Usage: confirmDelete(event, id, deleteFn, options)
      payload = arg2
      deleteFn = arg3
      options = arg4 || {}
    }

    confirm.require({
      target: event.currentTarget,
      message: options.message || 'Are you sure you want to delete this item?',
      icon: options.icon || 'pi pi-exclamation-triangle',
      acceptLabel: options.acceptLabel || 'Yes',
      rejectLabel: options.rejectLabel || 'No',
      acceptClass: options.acceptClass || 'p-button-danger',
      rejectClass: options.rejectClass || 'p-button-secondary p-button-outlined',
      acceptIcon: 'pi pi-trash',
      rejectIcon: 'pi pi-times',
      acceptProps: {
        severity: 'danger',
        class: 'custom-accept-btn'
      },
      rejectProps: {
        severity: 'secondary',
        class: 'custom-reject-btn'
      },
      accept: () => {
        if (payload !== null) {
          deleteFn(payload)
        } else {
          deleteFn()
        }
      },
      reject: () => {
      }
    })
  }

  return {
    confirm,
    capitalizeFirstLetter,
    confirmDelete 
  }
}
