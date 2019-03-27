/**
 * 按需加载 element ui
 */

// 载入样式
import 'element-ui/lib/theme-chalk/index.css'
import {
  Pagination,
  Dialog,
  Autocomplete,
  Dropdown,
  DropdownMenu,
  DropdownItem,
  Input,
  InputNumber,
  Radio,
  RadioGroup,
  RadioButton,
  Checkbox,
  CheckboxButton,
  CheckboxGroup,
  Select,
  Option,
  OptionGroup,
  Button,
  ButtonGroup,
  Table,
  TableColumn,
  DatePicker,
  TimeSelect,
  TimePicker,
  Popover,
  Tooltip,
  Alert,
  Icon,
  Loading,
  MessageBox,
  Message,
  Notification
} from 'element-ui'

const initElement = Vue => {
  Vue.use(Pagination)
  Vue.use(Dialog)
  Vue.use(Autocomplete)
  Vue.use(Dropdown)
  Vue.use(DropdownMenu)
  Vue.use(DropdownItem)
  Vue.use(Input)
  Vue.use(InputNumber)
  Vue.use(Radio)
  Vue.use(RadioGroup)
  Vue.use(RadioButton)
  Vue.use(Checkbox)
  Vue.use(CheckboxButton)
  Vue.use(CheckboxGroup)
  Vue.use(Select)
  Vue.use(Option)
  Vue.use(OptionGroup)
  Vue.use(Button)
  Vue.use(ButtonGroup)
  Vue.use(Table)
  Vue.use(TableColumn)
  Vue.use(DatePicker)
  Vue.use(TimeSelect)
  Vue.use(TimePicker)
  Vue.use(Popover)
  Vue.use(Tooltip)
  Vue.use(Alert)
  Vue.use(Icon)
  Vue.use(Loading.directive)

  Vue.prototype.$loading = Loading.service
  Vue.prototype.$msgbox = MessageBox
  Vue.prototype.$alert = MessageBox.alert
  Vue.prototype.$confirm = MessageBox.confirm
  Vue.prototype.$prompt = MessageBox.prompt
  Vue.prototype.$notify = Notification
  Vue.prototype.$message = Message
}
export default initElement
