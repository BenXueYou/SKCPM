import store from "../store";

const resident = {
  state: {
    curentLeftCheckedData: {},
    curLeftTagData: {},
    tagName: [],
    genderOptions: [],
    staffOptions: [],
    certificateOptions: [],
    educationOptions: [],
    countryOptions: [],
    nationOptions: [],
    maritalOptions: [],
    cardOptions: []
  },
  mutations: {
    'SET_Cur_Left_Tag_Data': (state, curLeftTagData) => {
      state.curLeftTagData = curLeftTagData;
    },
    'SET_LEFT_MENU_Data': (state, curentLeftCheckedData) => {
      state.curentLeftCheckedData = curentLeftCheckedData;
    },
    'SET_LEFT_MENU_Tag_Data': (state, tagName) => {
      state.tagName = tagName;
    },
    'SET_GENDEROPTIONS': (state, genderOptions) => {
      state.genderOptions = genderOptions;
    },
    'SET_STAFFOPTIONS': (state, staffOptions) => {
      state.staffOptions = staffOptions;
    },
    'SET_CERTIFICATE': (state, certificateOptions) => {
      state.certificateOptions = certificateOptions;
    },
    'SET_EDUOPTIONS': (state, educationOptions) => {
      state.educationOptions = educationOptions;
    },
    'SET_COUNTRY': (state, countryOptions) => {
      state.countryOptions = countryOptions;
    },
    'SET_NATION': (state, nationOptions) => {
      state.nationOptions = nationOptions;
    },
    'SET_MARITAL': (state, maritalOptions) => {
      state.maritalOptions = maritalOptions;
    },
    'SET_CARDOPTIONS': (state, cardOptions) => {
      state.cardOptions = cardOptions;
    },
  },
  getters: {
    'GET_CARDOPTIONS': (state) => {
      return state.cardOptions;
    },
    'GET_LEFT_MENU_Data': (state) => {
      return state.curentLeftCheckedData;
    },
    'GET_LEFT_MENU_Tag_Data': (state) => {
      return state.tagName;
    },
    'GET_GENDEROPTIONS': (state) => {
      return state.genderOptions;
    },
    'GET_STAFFOPTIONS': (state) => {
      return state.staffOptions;
    },
    'GET_CERTIFICATE': (state) => {
      return state.certificateOptions;
    },
    'GET_EDUOPTIONS': (state) => {
      return state.educationOptions;
    },
    'GET_COUNTRY': (state) => {
      return state.countryOptions;
    },
    'GET_NATION': (state) => {
      return state.nationOptions;
    },
    'GET_MARITAL': (state) => {
      return state.maritalOptions;
    },
    'GET_Cur_Left_Tag_Data': (state) => {
      return state.curLeftTagData;
    },
  },
  actions: {
    'SET_LEFT_MENU_Data': (state, curentLeftCheckedData) => {
      store.commit('SET_LEFT_MENU_Data', curentLeftCheckedData);
    }
  }
};

export default resident;
