import React from 'react';
import cn from 'classnames';
import omit from 'lodash/omit';

export default function Icon(props) {
  const { type, className = '' } = props;
  const classString = cn({
    tdcfont: true,
    [`tdc-${type}`]: !!type
  }, className);
  return <i {...omit(props, ['type'])} className={classString} />;
}