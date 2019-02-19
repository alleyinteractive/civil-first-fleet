/**
 * Custom media queries
 */
const bkptVal = {
  xxl: 90,
  xl: 80,
  lg: 64,
  md: 48,
  sm: 32,
};

module.exports = bkptVal;

module.exports = {
  xxlMin: `(min-width: ${bkptVal.xxl}rem)`,
  xxlMax: `(max-width: ${bkptVal.xxl - 0.0001}rem)`,
  xxlVal: `${bkptVal.xxl}rem`,
  xlMin: `(min-width: ${bkptVal.xl}rem)`,
  xlMax: `(max-width: ${bkptVal.xl - 0.0001}rem)`,
  xlVal: `${bkptVal.xl}rem`,
  lgMin: `(min-width: ${bkptVal.lg}rem)`,
  lgMax: `(max-width: ${bkptVal.lg - 0.0001}rem)`,
  lgVal: `${bkptVal.lg}rem`,
  mdMin: `(min-width: ${bkptVal.md}rem)`,
  mdMax: `(max-width: ${bkptVal.md - 0.0001}rem)`,
  mdVal: `${bkptVal.md}rem`,
  smMin: `(min-width: ${bkptVal.sm}rem)`,
  smMax: `(max-width: ${bkptVal.sm - 0.0001}rem)`,
  smVal: `${bkptVal.sm}rem`,
};
