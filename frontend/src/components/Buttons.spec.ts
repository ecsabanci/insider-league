import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Buttons from './Buttons.vue'

describe('Buttons', () => {
  it('emits playWeek when the play next week button is clicked', async () => {
    const wrapper = mount(Buttons, {
      props: { loading: false },
    })

    const buttons = wrapper.findAll('button')
    await buttons[0]?.trigger('click')

    expect(wrapper.emitted()).toHaveProperty('playWeek')
  })

  it('emits reset when the reset button is clicked', async () => {
    const wrapper = mount(Buttons, {
      props: { loading: false },
    })

    const buttons = wrapper.findAll('button')
    await buttons[2]?.trigger('click')

    expect(wrapper.emitted()).toHaveProperty('reset')
  })

  it('disables buttons when loading is true', () => {
    const wrapper = mount(Buttons, {
      props: { loading: true },
    })

    const buttons = wrapper.findAll('button')
    buttons.forEach((button) => {
      expect(button.attributes('disabled')).toBeDefined()
    })
  })
})